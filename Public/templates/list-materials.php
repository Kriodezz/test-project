<?php include __DIR__ . '/header.php'; ?>

<div class="container">
    <h1 class="my-md-5 my-4">Материалы</h1>

    <!-- Добавление нового материала -->
    <a class="btn btn-primary mb-4" href="<?php echo '/material/create'; ?>" role="button">
        Добавить
    </a>

    <!-- Панель поиска -->
    <div class="row">
        <div class="col-md-8">
            <form action="/materials/find" method="post">
                <div class="input-group mb-3">
                    <input type="text" class="form-control"
                           placeholder="Введите значение для поиска"
                           aria-label="Example text with button addon"
                           aria-describedby="button-addon1"
                           name="data-from-user">
                    <button class="btn btn-primary" type="submit" id="button-addon1">
                        Искать
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Список материалов -->
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Название</th>
                <th scope="col">Автор</th>
                <th scope="col">Тип</th>
                <th scope="col">Категория</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($data)) :
                foreach ($data as $item): ?>
            <tr>
                <td>
                    <a href="/material/show/<?php echo $item->getId(); ?>">
                        <?php echo $item->getTitle(); ?>
                    </a>
                </td>
                <td>
                    <?php if (!empty($item->getAuthors())) {
                        foreach ($item->getAuthors() as $keyAuthor => $author) {
                            echo $author->getName();
                            if ($keyAuthor < (count($item->getAuthors()) - 1)) {
                                echo ' / ';
                            }
                        }
                    } else {
                        echo 'Автор отсутствует';
                    } ?>
                </td>
                <td>
                    <?php echo $item->getType(); ?>
                </td>
                <td>
                    <?php echo $item->getCategory(); ?>
                </td>

                <!-- Редактирование материала -->
                <td class="text-nowrap text-end">
                    <a href="/material/edit/<?php echo $item->getId(); ?>" class="text-decoration-none me-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-pencil" viewBox="0 0 16 16">
                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                        </svg>
                    </a>

                    <!-- Удаление материала -->
                    <a class="text-decoration-none"
                       href="#deleteMaterial<?php echo $item->getId(); ?>"
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
                </td>
            </tr>
                <div class="modal fade"
                     id="deleteMaterial<?php echo $item->getId(); ?>"
                     aria-hidden="true"
                     aria-labelledby="deleteMaterialLabel"
                     tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteMaterialLabel">
                                    Удалить материал
                                </h5>
                                <button type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                        aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>
                                    Вы действительно хотите удалить материал <b><?php echo $item->getTitle(); ?></b>
                                </p>
                            </div>
                            <div class="modal-footer">
                                <a href="material/delete/<?php echo $item->getId(); ?>">
                                    <button type="submit" class="btn btn-primary">
                                        Удалить
                                    </button>
                                </a>
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    Отмена
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach;
            endif; ?>
            </tbody>
        </table>
    </div>
</div>
</div>

<?php include __DIR__ . '/footer.html';
