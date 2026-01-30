// https://www.youtube.com/watch?v=V-CBdlfCPic
// https://developer.mozilla.org/en-US/docs/Web/API/DOMTokenList/toggle

const primaryHeader = document.querySelector(".primary-hdr");
const scrollWatcher = document.createElement("div");

scrollWatcher.setAttribute("data-scroll-watcher", "");
primaryHeader.before(scrollWatcher);

const navObserver = new IntersectionObserver(
	(entries) => {
		primaryHeader.classList.toggle("sticking", !entries[0].isIntersecting);
	},
	{ rootMargin: "0px 0px 0px 0px" }
	// top right bottom left (px or %) At 0px top toggle happens right away
	// add px to top to delay toggle by x px
);

navObserver.observe(scrollWatcher);
