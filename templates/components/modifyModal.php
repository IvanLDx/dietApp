<div class="modify-modal js-modify-modal">
    <div class="modify-modal__backdrop">
        <div class="modify-modal__wrapper">
            <p class="title">Modifica o prato</p>

            <form action="Dish-Modify" class="js-modify-form">
                <input type="hidden" name="dish-id" class="js-dish-id">
                <input type="text" name="dish-name" class="dish-name js-dish-modify-name" autocomplete="off">
                <?php
                $section = "modal";
                require('./templates/addDish/seasonInputs.php')
                ?>
                <input type="submit" value="Dálle" class="modify-accept">
            </form>
            <button class="modify-cancel js-close-modal">Cancelar a modificación</button>
        </div>
    </div>
</div>