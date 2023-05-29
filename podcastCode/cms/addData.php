<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <title>Add Data | Podcast</title>
    <link rel="stylesheet" href="../client/css/master.css">
    <link rel="stylesheet" href="./css/addData.css">
</head>
<body>
    <div class="page background-black">
        <h1 class="font-blue">Engade unha nova entrada</h1>
        <form action="">
            <div class="inputs background-white font-black">
                <div class="input input-pod">
                    <label for="pod">Pod</label>
                    <select type="text" name="pod" data-required="true">
                        <option value="asefemeridas">As efeméridas</option>
                    </select>
                </div>
                <div class="input input-name">
                    <label for="name">Nome</label>
                    <input type="text" name="name" data-required="true">
                </div>
                <div class="input input-date" style="display:none">
                    <label for="date">Data</label>
                    <input type="date" name="date">
                </div>
                <div class="input input-season">
                    <label for="season">Tempada</label>
                    <input type="text" name="season" data-required="true">
                </div>
                <div class="input input-episode">
                    <label for="episode">Episodio</label>
                    <input type="text" name="episode" data-required="true">
                </div>
                <div class="input-submit">
                    <input type="submit" class="submit" value="Dálle!">
                </div>
            </div>
        </form>
    </div>
    <script type="module" src="js/addData.js"></script>
</body>
</html>