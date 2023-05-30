<div class="input__container">
    <form action="Dish-Add" method="POST" class="js-add-dish">
        <label class="input__label" for="dish-name">Nome do prato</label>
        <input class="input js-dish-name" name="dish-name" id="dish-name" type="text" autocomplete="off">
        
        <?php
        $section = "main";
        require('./templates/addDish/seasonInputs.php');

        require('./templates/addDish/tags.php');
        ?>

        <input class="submit js-submit-dish" type="submit" value="Dálle!">
    </form>

    <div class="tag-form-hidden">
        <form action="Tag-Add" method="GET" class="js-add-tag">
            <input type="text" class="new-tag-name js-tag-name-destination" name="tag-name">
            <input type="color" class="tag-color js-tag-color-destination" name="tag-color">
            <input type="submit" class="tag-submit js-tag-submit-destination">
        </form>
    </div>
</div>
