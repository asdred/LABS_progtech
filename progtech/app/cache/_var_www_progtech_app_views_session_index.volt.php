<?php echo $this->tag->form(array('session/start')); ?>
    <fieldset>
        <div>
            <label for="email">Логин/Email</label>
            <div>
                <?php echo $this->tag->textField(array('email')); ?>
            </div>
        </div>
        <div>
            <label for="password">Пароль</label>
            <div>
                <?php echo $this->tag->passwordField(array('password')); ?>
            </div>
        </div>
        <div>
            <?php echo $this->tag->submitButton(array('Войти')); ?>
        </div>
    </fieldset>
</form>