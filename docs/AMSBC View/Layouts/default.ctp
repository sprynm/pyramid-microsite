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

if (isset($curTop['NavigationMenuItem']['id'])) {
  $subNavItems = $this->Navigation->subnavItems($curTop['NavigationMenuItem']['id']);
  $hasSubNav = !empty($subNavItems);
}

$subnavLabel = __('Section navigation');
$subnavSelectId = isset($curTop['NavigationMenuItem']['id'])
  ? 'subnav-select-' . $curTop['NavigationMenuItem']['id']
  : 'subnav-select';

$layoutClasses = array('l-single');
if ($hasSubNav) {
  $layoutClasses[] = 'l-with-subnav';
}

// Normalize current request path once
$currentPath = rtrim(parse_url($this->request->here, PHP_URL_PATH), '/');
?>
<div id="content" class="site-wrapper site-wrapper--default">
  <div class="c-container c-container--normal">
    <div class="<?php echo implode(' ', $layoutClasses); ?>">
      <main class="default layout-default">
        <?php
        if (!empty($pageIntro)) {
          echo $this->Html->div('layout-rail', $pageIntro);
        }

        echo $this->Session->flash();
        echo $this->fetch('content');
        ?>
      </main>

      <?php if ($hasSubNav): ?>
        <div>
          <h4 class="subnav__heading">In This Section</h4>
          <div class="subnav subnav--select">
            <label class="visually-hidden" for="<?php echo h($subnavSelectId); ?>"><?php echo h($subnavLabel); ?></label>
            <select id="<?php echo h($subnavSelectId); ?>" class="c-select js-subnav-select"
              aria-label="<?php echo h($subnavLabel); ?>">
              <?php foreach ($subNavItems as $item):
                $itemHref = $this->Html->url($item['url']);
                $itemPath = rtrim(parse_url($itemHref, PHP_URL_PATH), '/');
                $isCurrent = ($itemPath === $currentPath);
                ?>
                <option value="<?php echo h($item['url']); ?>" <?php echo $isCurrent ? ' selected' : ''; ?>>
                  <?php echo h($item['title']); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <nav class="subnav subnav--list" aria-label="<?php echo h($subnavLabel); ?>">
            <ul>
              <?php foreach ($subNavItems as $item):
                $itemHref = $this->Html->url($item['url']);
                $itemPath = rtrim(parse_url($itemHref, PHP_URL_PATH), '/');

                // Compute class: exact match = current; ancestor path-prefix = ancestor; else none.
                $isCurrent = ($itemPath === $currentPath);
                $isAncestor = (!$isCurrent && strpos($currentPath . '/', $itemPath . '/') === 0);

                $cls = $isCurrent ? 'current' : ($isAncestor ? 'ancestor' : '');
                ?>
                <li<?php echo $cls ? ' class="' . h($cls) . '"' : ''; ?>>
                  <a href="<?php echo h($item['url']); ?>" <?php echo $isCurrent ? ' aria-current="page"' : ''; ?>>
                    <?php echo h($item['title']); ?>
                  </a>
                  </li>
                <?php endforeach; ?>
            </ul>
          </nav>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div><!-- "content" ends -->
<?php
echo $this->element('layout/footer');
?>