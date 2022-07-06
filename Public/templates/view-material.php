<?php include __DIR__ . '/header.php'; ?>

    <!-- Страница просмотра материала -->
    <div class="container">

        <!-- Название -->
        <h1 class="my-md-5 my-4"><?php echo $material->getTitle(); ?></h1>
        <div class="row mb-3">
            <div class="col-lg-6 col-md-8">
                <div class="d-flex text-break">

                    <!-- Авторы -->
                    <p class="col fw-bold mw-25 mw-sm-30 me-2">Авторы</p>
                    <p class="col">
                        <?php if (!empty($material->getAuthors())) {
                            foreach ($material->getAuthors() as $keyAuthor => $author) {
                                echo $author->getName();
                                if ($keyAuthor < (count($material->getAuthors()) - 1)) {
                                    echo ' / ';
                                }
                            }
                        } else {
                            echo 'Автор отсутствует';
                        } ?>
                    </p>
                </div>

                <!-- Тип -->
                <div class="d-flex text-break">
                    <p class="col fw-bold mw-25 mw-sm-30 me-2">Тип</p>
                    <p class="col">
                        <?php echo $material->getType(); ?>
                    </p>
                </div>

                <!-- Категории -->
                <div class="d-flex text-break">
                    <p class="col fw-bold mw-25 mw-sm-30 me-2">Категория</p>
                    <p class="col">
                        <?php echo $material->getCategory(); ?>
                    </p>
                </div>

                <!-- Описание -->
                <div class="d-flex text-break">
                    <p class="col fw-bold mw-25 mw-sm-30 me-2">Описание</p>
                    <p class="col">
                        <?php if ($material->getDescription() !== null) {
                            echo $material->getDescription();
                        } else {
                            echo 'Описание отсутствует';
                        } ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Блок тегов -->
        <div class="row">
            <div class="col-md-6">

                <!-- Добавление тегов -->
                <form action="/tags/add-to/<?php echo $material->getId(); ?>" method="post">
                    <h3>Теги</h3>
                    <div class="input-group mb-3">
                        <select class="form-select" name="tag" id="selectAddTag" aria-label="Добавьте теги">
                            <?php foreach ($tags as $tag): ?>
                                <option
                                    <?php if ($tag->getTitle() === 0) {
                                        echo 'selected';
                                    } ?>
                                        value="<?php echo $tag->getId(); ?>">
                                    <?php echo $tag->getTitle(); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button class="btn btn-primary" type="submit">Добавить</button>
                    </div>
                </form>

                <!-- Список тегов материала -->
                <ul class="list-group mb-4">
                    <?php if (!empty($material->getTags())) {
                        foreach ($material->getTags() as $tag): ?>
                            <li class="list-group-item list-group-item-action d-flex justify-content-between">
                                <a href="/find/tag/<?php echo $tag->getID(); ?>" class="me-3">
                                    <?php echo $tag->getTitle(); ?>
                                </a>

                                <!-- Удаление тега из материала -->
                                <a href="/tag/<?php echo $tag->getID(); ?>/delete/<?php echo $material->getId(); ?>"
                                   class="text-decoration-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                         class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                        <path fill-rule="evenodd"
                                              d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                    </svg>
                                </a>
                            </li>
                        <?php endforeach;
                    } ?>
                </ul>
            </div>

            <!-- Ссылки -->
            <div class="col-md-6">
                <div class="d-flex justify-content-between mb-3">
                    <h3>Ссылки</h3>

                    <!-- Добавление ссылок -->
                    <a class="btn btn-primary"
                       data-bs-toggle="modal"
                       href="#exampleModalToggle<?php echo '' ?>"
                       role="button">
                        Добавить
                    </a>
                </div>
                <?php include __DIR__ . '/add-edit-link.php'; ?>

                <!-- Список ссылок -->
                <ul class="list-group mb-4">
                    <?php if (!empty($material->getLinks())) :
                        foreach ($material->getLinks() as $link) : ?>
                            <li class="list-group-item list-group-item-action d-flex justify-content-between">
                                <a href="<?php echo $link->getLink(); ?>" class="me-3">
                                    <?php if ($link->getSignature() !== null) {
                                        echo $link->getSignature();
                                    } else {
                                        echo $link->getLink();
                                    } ?>
                                </a>
                                <span class="text-nowrap">
                        <a href="#exampleModalToggle<?php echo $link->getId(); ?>"
                           class="text-decoration-none me-2"
                           data-bs-toggle="modal">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 width="16"
                                 height="16"
                                 fill="currentColor"
                                 class="bi bi-pencil"
                                 viewBox="0 0 16 16">
                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                            </svg>
                        </a>
                        <a href="#deleteLink<?php echo $link->getId(); ?>"
                           class="text-decoration-none"
                           data-bs-toggle="modal">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 width="16"
                                 height="16"
                                 fill="currentColor"
                                 class="bi bi-trash"
                                 viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                <path fill-rule="evenodd"
                                      d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                            </svg>
                        </a>
                    </span>
                            </li>

                        <?php include __DIR__ . '/add-edit-link.php'; ?>

                            <!-- Модальное окно подтверждения удаления ссылки -->
                            <div class="modal fade"
                                 id="deleteLink<?php echo $link->getId(); ?>"
                                 aria-hidden="true"
                                 aria-labelledby="deleteLink"
                                 tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteLinkLabel">
                                                Удалить тег
                                            </h5>
                                            <button type="button"
                                                    class="btn-close"
                                                    data-bs-dismiss="modal"
                                                    aria-label="Close">
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>
                                                Вы действительно хотите удалить ссылку
                                                <b>
                                                    <?php if ($link->getSignature() !== null) {
                                                        echo $link->getSignature();
                                                    } else {
                                                        echo $link->getLink();
                                                    } ?>
                                                </b>
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="/link/<?php echo $link->getId(); ?>/delete/<?php echo $material->getId(); ?>">
                                                <button type="submit" class="btn btn-primary">
                                                    Удалить
                                                </button>
                                            </a>
                                            <button type="button" class="btn btn-outline-secondary"
                                                    data-bs-dismiss="modal">
                                                Отмена
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;
                    endif; ?>
                </ul>
            </div>
        </div>
    </div>
    </div>
<?php include __DIR__ . '/footer.html';
