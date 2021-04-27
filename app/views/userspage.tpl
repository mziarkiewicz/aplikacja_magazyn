{extends file='main.tpl'}

{block name=top}
    <!-- Main -->
    <div id="main" class="wrapper style1">
        <div class="container">
            <header class="major">
                <h2>Panel zarządzania użytkownikami</h2>
            </header>
            <!-- Content -->
            <section id="tabela">
                    <div class="container">
                        <h3>Tabela użytkowników</h3>
                        <table class="alt">
                            <thead>
                            <tr>
                                <th>Login</th>
                                <th>Rola</th>
                                <th>Edytuj</th>
                                <th>Usuń</th>

                            </tr>
                            </thead>
                            <tbody>
                            {foreach $lista as $wiersz}
                                <tr>
                                    <td>{$wiersz["login"]}</td>
                                    <td>{$wiersz["nazwa"]}</td>
                                    <td style="width: 1em"><a href="{$conf->action_root}userEdit/{$wiersz['iduser']}" class="button primary small">Edytuj</a></td>
                                    <td style="width: 1em"><a href="{$conf->action_root}userDelete/{$wiersz['iduser']}" onclick="return confirm('Czy na pewno chcesz usunąć tego użytkownika?')" class="button small">Usuń</a></td>
                                </tr>
                            {/foreach}
                            </tbody>
                        </table>
{*                        <a href="#" class="button small"><</a>*}
{*                        <a href="#" class="button small">></a>*}
                    </div>
            </section>
            <br/>
            {include file='messages.tpl'}
        </div>
    </div>
{/block}
