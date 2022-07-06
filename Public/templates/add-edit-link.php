<!-- Модальное окно добавления ссылки -->
<!-- Если $link существует, редактируется имеющаяся ссылка,
 если нет - создаётся новая -->
<div class="modal fade"
     id="exampleModalToggle<?php if (isset($link)) {
                                echo $link->getId();
                            } else {
                                echo '';
                            } ?>"
     aria-hidden="true"
     aria-labelledby="exampleModalToggleLabel"
     tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">Добавить ссылку</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/link/add/<?php
            echo $material->getId();
            if (isset($link)) {
                echo '/' . $link->getId();
            }
            ?>" method="post">
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input type="text"
                               name="signature"
                               value="<?php if (isset($link)) {
                                   if ($link->getSignature() !== null) {
                                       echo $link->getSignature();
                                   } else {
                                       echo $link->getLink();
                                   }
                               } else {
                                   echo '';
                               } ?>"
                               class="form-control"
                               placeholder="Добавьте подпись"
                               id="floatingModalSignature">
                        <label for="floatingModalSignature">
                            Подпись
                        </label>
                        <div class="invalid-feedback">
                            Пожалуйста, заполните поле
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text"
                               name="link"
                               value="<?php if (isset($link)) {
                                   echo $link->getLink();
                               } else {
                                   echo '';
                               } ?>"
                               class="form-control"
                               placeholder="Добавьте ссылку"
                               id="floatingModalLink">
                        <label for="floatingModalLink">
                             Ссылка
                        </label>
                        <div class="invalid-feedback">
                            Пожалуйста, заполните поле
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Добавить</button>
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Закрыть</button>
                </div>
            </form>
        </div>
    </div>
</div>
