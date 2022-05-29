{extends file='main.tpl'}

{block name=top}
    <!-- Main -->
    <div id="main" class="wrapper style1">
        <div class="container">
            <header class="major">
                <h2>Aplikacja wspomagająca ewidencję urządzeń</h2>
                <p>Zaloguj się, aby skorzystać z systemu</p>
            </header>

            <!-- Form -->
            <section>
                <h3>Logowanie</h3>
                <form method="post" id="login_form" action="{$conf->action_url}login">
                    <div class="row gtr-uniform gtr-50">
                        <div class="col-6">
                            <input type="text" name="login" id="id_login" placeholder="Login" />
                        </div>
                        <div class="col-6">
                            <input type="password" name="pass" id="id_pass" placeholder="Hasło" />
                        </div>
                        <div class="col-12">
{*                            <button class="g-recaptcha" class="button primary"*}
{*                                    data-sitekey="6Lel8pQfAAAAAFn2IBtjpyGJkA8b7cIHnpdOx5sp"*}
{*                                    data-callback='onSubmit'*}
{*                                    data-action='submit'>Zaloguj</button>*}
                            <input type="submit" value="Zaloguj" class=" button primary fit" />
                        </div>
                    </div>
                </form>
            </section>
        </div>

    {include file='messages.tpl'}
    </div>
{/block}
