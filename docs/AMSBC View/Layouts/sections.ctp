<?php
echo $this->element('layout/head');
echo $this->element('layout/nav');
echo $this->element('layout/body_masthead', array(
  'banner' => isset($banner) ? $banner : array(),
  'page' => isset($page) ? $page : array(),
  'pageHeading' => isset($pageHeading) ? $pageHeading : '',
  'bodyId' => isset($bodyId) ? $bodyId : null,
));
$curTop = $this->Navigation->topCurrentItem();
$subNavItems = array();
$hasSubNav = false;
?>

<div id="content" class="site-wrapper site-wrapper--sections">
  <div class="c-container c-container--normal">
    <div class="l-sections l-with-subnav">
      <main class="default layout-default">
        <?php
        if (!empty($pageIntro)) {
          echo $this->Html->div('layout-rail', $pageIntro);
        }

        echo $this->Session->flash();
        echo $this->fetch('content');
        ?>
      </main>
      <aside class="jumpnav subnav--list subnav--sticky">
        <h4 class="subnav__heading">Table of Contents</h4>

      </aside>
    </div>
  </div>
</div><!-- "content" ends -->
<?php
echo $this->element('layout/footer');
?>

<!-- Place this anywhere on the page (preferably after the content).
     It will find <aside> and inject the subnav matching your styles. -->
<script>
  (function () {
    function slugify(text) {
      return (text || "")
        .toLowerCase()
        .trim()
        .replace(/[^\w\s-]/g, "")
        .replace(/\s+/g, "-")
        .replace(/-+/g, "-")
        .slice(0, 64);
    }

    function isVisible(el) {
      return !!(el && el.offsetParent !== null);
    }

    function uniqueId(base, used) {
      let id = base || "section";
      let n = 1;
      while (used.has(id) || document.getElementById(id)) {
        id = `${base}-${n++}`;
      }
      used.add(id);
      return id;
    }

    function buildSectionSubnav({
      scope = "main",          // container to scan for h2
      aside = "aside",         // where to render the nav
      headingSelector = "h2",  // which headings to turn into links
      navAria = "Section navigation"
    } = {}) {
      const root = typeof scope === "string" ? document.querySelector(scope) : scope;
      const asideEl = typeof aside === "string" ? document.querySelector(aside) : aside;
      if (!root || !asideEl) return;

      const headings = Array.from(root.querySelectorAll(headingSelector)).filter(isVisible);
      if (!headings.length) return;

      // Ensure each heading has a unique id
      const used = new Set();
      headings.forEach(h => {
        if (!h.id) {
          h.id = uniqueId(slugify(h.textContent), used);
        } else {
          used.add(h.id);
        }
        // play nice with sticky headers if present
        h.style.scrollMarginTop ||= "24px";
      });

      // Build exact structure expected by site styles
      const nav = document.createElement("nav");
      nav.className = "subnav subnav--list";
      nav.setAttribute("aria-label", navAria);

      const ul = document.createElement("ul");
      nav.appendChild(ul);

      const lis = headings.map((h, idx) => {
        const li = document.createElement("li");
        if (idx === 0) li.classList.add("first");
        if (idx === headings.length - 1) li.classList.add("last");

        const a = document.createElement("a");
        a.href = `#${h.id}`;
        a.textContent = (h.textContent || "").trim();
        li.appendChild(a);
        ul.appendChild(li);
        return { li, a, h };
      });

      // Replace any existing subnav inside the aside
      const existing = asideEl.querySelector(".subnav.subnav--list");
      if (existing) existing.remove();
      asideEl.appendChild(nav);

      // Set initial "current" state from hash (or first item)
      function setCurrentById(id) {
        lis.forEach(({ li, a }) => {
          li.classList.remove("current");
          a.removeAttribute("aria-current");
        });
        const match = lis.find(x => x.h.id === id) || lis[0];
        if (match) {
          match.li.classList.add("current");
          match.a.setAttribute("aria-current", "page");
        }
      }
      setCurrentById(location.hash.slice(1));

      // Keep "current" in sync while scrolling
      if ("IntersectionObserver" in window) {
        const CLEAR_AT_TOP_PX = 8; // tweak to taste (prevents first item selection at top)
        const clear = () => lis.forEach(({ li, a }) => { li.classList.remove("current"); a.removeAttribute("aria-current"); });

        const anchorById = Object.fromEntries(lis.map(x => [x.h.id, x]));
        const io = new IntersectionObserver((entries) => {
          // If we're at the very top, don't select anything
          if (window.scrollY <= CLEAR_AT_TOP_PX) {
            clear();
            return;
          }

          // Consider only items inside the sweet-spot band
          const visible = entries.filter(e => e.isIntersecting);
          if (!visible.length) return;

          // Pick the one nearest the top of the band
          visible.sort((a, b) => a.boundingClientRect.top - b.boundingClientRect.top);
          const id = visible[0].target.id;
          const hit = anchorById[id];
          if (!hit) return;

          clear();
          hit.li.classList.add("current");
          hit.a.setAttribute("aria-current", "page");
        }, {
          root: null,
          rootMargin: "-40% 0px -55% 0px",
          threshold: [0, 1]
        });

        headings.forEach(h => io.observe(h));

        // Also clear on load if we start at top (e.g., after a hard refresh)
        if (window.scrollY <= CLEAR_AT_TOP_PX) clear();
      }

      // Optional: update current on click + preserve hash
      ul.addEventListener("click", (e) => {
        const a = e.target.closest("a[href^='#']");
        if (!a) return;
        // Let the browser scroll, just manage current class immediately
        const id = a.getAttribute("href").slice(1);
        setCurrentById(id);
      });

      return nav;
    }

    // Expose and auto-run for common layout:
    window.buildSectionSubnav = buildSectionSubnav;
    // Auto-init: scan main and render into the first <aside>
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () => buildSectionSubnav({ scope: "main", aside: "aside" }));
    } else {
      buildSectionSubnav({ scope: "main", aside: "aside" });
    }
  })();
</script>