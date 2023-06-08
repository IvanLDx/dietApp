<div class="remove-popup js-remove-popup">
    <?php
        switch ($currentPageName) {
            case 'addDish': ?>
                <p>Queres elimina-lo prato <b><span class="js-dish-name-popup">Tortilla</span></b>?</p>
                <?php break;
            case 'weeklyMeals': ?>
                <p>Queres reinicia-lo calendario?</p>
                <?php break;
            default:
                break;
        }
    ?>
    <form action="Dish-Remove" class="js-remove-popup-form">
        <input type="hidden" name="season" class="js-dish-season-popup">
        <input type="hidden" name="dish-id" class="js-dish-id-popup">
        <input type="submit" value="Dálle!">
    </form>
    <button class="js-close-popup">Cancelar</button>
</div>