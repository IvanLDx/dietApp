<div class="tags-container">
    <label for="tag-check" class="span">
        <?php require('./client/static/svg/tag.svg') ?>
    </label>
    <input id="tag-check" class="tag-check js-tag-check" type="checkbox">
    
    <div class="tags-modal">
        <div class="add-tag-form">
            <input type="text" class="new-tag-name js-tag-name-source">
            <input type="color" class="tag-color js-tag-color-source">
            <div class="tag-submit js-tag-submit">
                <?php require('./client/static/svg/tag-right.svg') ?>
            </div>
        </div>
        <div class="tag-container js-tag-container">
        </div>
    </div>

    <div class="js-tags tags"></div>
</div>