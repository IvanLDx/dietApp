<div class="tags-container">
    <label for="tag-check" class="span js-open-tag-modal">
        <?php echo file_get_contents("$root/client/static/svg/tag.svg") ?>
    </label>
    <input id="tag-check" class="tag-check js-tag-check" type="checkbox">
    
    <div class="tags-modal">
        <div class="add-tag-form">
            <input type="text" class="new-tag-name js-tag-name-source">
            <input type="color" class="tag-color js-tag-color-source">
            <div class="tag-submit js-tag-submit">
                <?php echo file_get_contents("$root/client/static/svg/tag-right.svg") ?>
            </div>
        </div>
        <div class="tag-container js-tag-container listed" data-action="Tag-Remove">
            
            <?php
            $tags = json_decode(file_get_contents($root . "/data/tags.json"));
            $iconUrl = "$root/client/static/svg/close.svg";
            $templateUrl = "$root/templates";
            include "$templateUrl/tags/list.php";
            ?>

        </div>
    </div>

    <input type="hidden" class="js-tag-ids tag-ids" name="tags">
    <ul class="js-tags tags"></ul>
</div>