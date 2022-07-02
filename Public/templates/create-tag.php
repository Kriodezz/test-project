<?php include __DIR__ . '/header.php'; ?>

        <div class="container">
            <h1 class="my-md-5 my-4"><?php echo $act; ?> тег</h1>
            <div class="row">
                <div class="col-lg-5 col-md-8">
                    <form action="<?php echo $action; ?>" method="post">
                        <div class="form-floating mb-3">
                            <input type="text" name="tag" class="form-control" placeholder="Напишите название" id="floatingName">
                            <label for="floatingName">Название</label>
                            <?php if (isset($exceptions['tag'])) { ?>
                                <p class="text-danger">Имя тега не должно быть пустым</p>
                            <?php } ?>
                            <div class="invalid-feedback">
                                Пожалуйста, заполните поле
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit"><?php echo $button; ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php include __DIR__ . '/footer.html';
