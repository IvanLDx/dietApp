<div class="input__container">
    <form action="Dish-Add" method="POST" class="js-add-dish">
        <label class="input__label" for="dish-name">Nome do prato</label>
        <input class="input js-dish-name" name="dish-name" id="dish-name" type="text" autocomplete="off">
        
        <?php
        $section = "main";
        require('./templates/addDish/seasonInputs.php');
        ?>

        <div class="tags-container">
            <div class="js-tags tags"></div>
            <span class="span">Etiquitas</span>
        </div>
        <input class="submit" type="submit" value="Dálle!">
    </form>
</div>
