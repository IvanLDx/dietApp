<div class="input__container">
    <form action="Dish-Add" method="POST" class="js-add-dish">
        <label class="input__label" for="dish-name">Nome do prato</label>
        <input class="input js-dish-name" name="dish-name" id="dish-name" type="text" autocomplete="off">
        <div class="season-inputs">
            <div class="summer-container">
                <input type="radio" name="season" value="summer" id="summer" class="js-season-radio">
                <label for="summer">Verán</label>
            </div>
            <div class="winter-container">
                <input type="radio" name="season" value="winter" id="winter" class="js-season-radio">
                <label for="winter">Inverno</label>
            </div>
            <div class="halftime-container">
                <input type="radio" name="season" value="halftime" id="halftime" class="js-season-radio">
                <label for="halftime">Entretempo</label>
            </div>
        </div>
        <input class="submit" type="submit" value="Dálle!">
    </form>
</div>
