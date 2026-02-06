<?php
function createNavItem($folder,$title, $iconName, $page, $edit_id = null, $isActive = false) {
    $href = !empty($edit_id)
        ? ROOT_DIR . "{$folder}/{$page}/edit/{$edit_id}.html"
        : '#';

    $linkAttributes = !empty($edit_id)
        ? 'href="' . $href . '"'
        : 'style="pointer-events: none; color: gray;"';

    $activeClass = $isActive ? 'active' : '';

    return <<<HTML
<li class="nav-item" role="presentation">
    <a class="nav-link {$activeClass}" {$linkAttributes}>
        <div class="d-flex align-items-center">
            <div class="tab-icon">
                <ion-icon name="{$iconName}" class="me-1"></ion-icon>
            </div>
            <div class="tab-title">{$title}</div>
        </div>
    </a>
</li>
HTML;
}
?>
