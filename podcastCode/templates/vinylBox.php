<div class="vinyl-box">
    <div class="vinyl-container">
        <div class="vinyl-pod js-vinyl">
            <img src="./client/img/svg/vinyl-red.svg" alt="Vinyl" class="vinyl">
            <img src="./client/img/webp/asefemeridas.webp" alt="As efeméridas" class="vinyl-case">
        </div>
        <div class="vinyl-pod js-vinyl">
            <img src="./client/img/svg/vinyl-blue.svg" alt="Vinyl" class="vinyl">
            <img src="./client/img/webp/acontece.webp" alt="As efeméridas" class="vinyl-case">
        </div>

        <?php for ($i = 0; $i < 12; $i++) { ?>
            <div class="vinyl-pod js-vinyl empty">
                <img src="./client/img/webp/generic-vinyl.webp" alt="Generic vinyl" class="vinyl-case">
            </div>
        <?php }?>
    </div>
</div>
