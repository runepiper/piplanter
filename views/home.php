<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style><?php echo file_get_contents('assets/stylesheets/above-the-fold.min.css'); ?></style>
        <title>PiPlanter</title>
    </head>
    <body>
        <header class="header">
            <h1 class="header__headline">PiPlanter</h1>
        </header>
        <main class="main">
            <form class="form" action="#" method="POST">
                <label class="form__label">
                    <input class="form__input" type="number" name="amount" placeholder="Menge"><span class="form__input-aside">ml</span>
                </label>
                <button class="form__button form__button--will-load" type="submit">Wässern</button>
            </form>
            <?php if(count($log) > 0) { ?>
                <table class="table">
                    <thead class="table__header">
                        <tr class="table__row">
                            <th class="table__cell">Zuletzt gegossen am</th>
                            <th class="table__cell">Menge</th>
                        </tr>
                    </thead>
                    <tbody class="table__body">
                        <?php foreach ($log as $row) { ?>
                            <tr class="table__row">
                                <td class="table__cell"><?php echo date('d.m.Y', $row['crdate']); ?></td>
                                <td class="table__cell"><?php echo $row['amount']; ?> ml</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>
        </main>
        <script>
            var head = document.head;
            head.innerHTML += '<link href="assets/stylesheets/combined.min.css" rel="stylesheet">';
        </script>
        <script src="assets/javascripts/combined.min.js" async></script>
    </body>
</html>
