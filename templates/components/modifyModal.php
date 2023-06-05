<div class="modify-modal js-modify-modal">
    <div class="modify-modal__backdrop">
        <div class="modify-modal__wrapper">
            <p class="title">Modifica o prato</p>

            <form action="Dish-Modify" class="js-modify-form">
                <input type="hidden" name="dish-id" class="js-dish-id">
                <input type="text" name="dish-name" class="dish-name js-dish-modify-name" autocomplete="off">
                <?php
                $section = "modal";
                require('./templates/addDish/seasonInputs.php');
                ?>

                <label for="tag-check-modify" class="span js-open-tag-modal-modify">
                    <?php require('./client/static/svg/tag.svg') ?>
                </label>
                <input id="tag-check-modify" class="tag-check js-tag-check-modify" type="checkbox">

                <div class="tags-modal listed">
                    <?php
                    $tags = json_decode(file_get_contents('./data/tags.json'));
                    $iconUrl = './client/static/svg/close.svg';
                    require('./templates/tags/list.php');
                    ?>
                </div>

                <div class="dish-tags">
                    <ul class="js-dish-tags-modal"></ul>
                </div>

                <input type="submit" value="Dálle" class="modify-accept">
            </form>
            <button class="modify-cancel js-close-modal">Cancelar a modificación</button>
        </div>
    </div>
</div>