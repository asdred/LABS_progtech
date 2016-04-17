{{ form('session/start') }}
    <fieldset>
        <div>
            <label for="email">Логин/Email</label>
            <div>
                {{ text_field('email') }}
            </div>
        </div>
        <div>
            <label for="password">Пароль</label>
            <div>
                {{ password_field('password') }}
            </div>
        </div>
        <div>
            {{ submit_button('Войти') }}
        </div>
    </fieldset>
</form>