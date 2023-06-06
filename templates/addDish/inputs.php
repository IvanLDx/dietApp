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

    <?php require('./templates/addDish/tagFormHidden.php') ?>
</div>
