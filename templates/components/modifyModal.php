<div class="modify-modal js-modify-modal">
    <div class="modify-modal__backdrop">
        <div class="modify-modal__wrapper">
            <p class="title">Modifica o prato</p>

            <form action="Dish-Modify" class="js-modify-form">
                <input type="hidden" name="dish-id" class="js-dish-id">
                <input type="text" name="dish-name" class="dish-name js-dish-modify-name" autocomplete="off">
                <?php
                $section = "modal";
                include "$root/templates/addDish/seasonInputs.php";
                ?>

                <div class="tags-container">
                    <label for="tag-check-modify" class="span js-open-tag-modal-modify">
                        <?= file_get_contents($root . "/clientV" . $clientVersion . "/static/svg/tag.svg") ?>
                    </label>
                    <input id="tag-check-modify" class="tag-check js-tag-check-modify" type="checkbox">
    
                    <div class="js-tags-modal-container tags-modal tags-modify-modal listed">
                        <?php
                        $tags = json_decode(file_get_contents($root . "/data/tags.json"));
                        $iconUrl = "$root/clientV" . $clientVersion . "/static/svg/close.svg";

                        $templateUrl = "$root/templates";
                        include "$templateUrl/tags/list.php";
                        ?>
                    </div>

                    <input type="hidden" class="js-modify-tag-ids tag-ids" name="tags">
    
                    <div class="dish-tags">
                        <ul class="js-dish-tags-modal"></ul>
                    </div>
                </div>

                <input type="submit" value="Dálle" class="modify-accept">
            </form>
            <button class="modify-cancel js-close-modal">Cancelar a modificación</button>
        </div>
    </div>
</div>