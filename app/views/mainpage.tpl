{extends file='main.tpl'}

{block name=top}
    <!-- Main -->
    <div id="main" class="wrapper style1">
        <div class="container">
            <header class="major">
                <h2>Panel główny</h2>
            </header>
            <!-- Content -->
            <section id="content">
                <div class="container">
                    <h3>Wyszukiwarka</h3>
                    <form method="get" action="{$conf->action_root}search">
                        <div class="row gtr-uniform gtr-50">
                            <div class="col-3 col-12-xsmall">
                                <input type="text" name="nazwa" list="nazwaHints" placeholder="Nazwa"
                                       onkeyup="ajaxReloadElement('nazwaHints','{$conf->action_root}hint?column=nazwa&value='+this.value)">
                                <datalist id="nazwaHints">
                                </datalist>
                            </div>
                            <div class="col-3 col-12-xsmall">
                                <input type="text" name="producent" list="producentHints" placeholder="Producent"
                                       onkeyup="ajaxReloadElement('producentHints','{$conf->action_root}hint?column=producent&value='+this.value)">
                                <datalist id="producentHints">
                                </datalist>
                            </div>
                            <div class="col-2 col-12-xsmall">
                                <input type="text" name="modelurz" list="modelHints" placeholder="Model"
                                       onkeyup="ajaxReloadElement('modelHints','{$conf->action_root}hint?column=model&value='+this.value)">
                                <datalist id="modelHints">
                                </datalist>
                            </div>
                            <div class="col-2 col-12-xsmall">
                                <select name="iddzial" id="iddzial">
                                    <option value="">- Dział -</option>
                                    <option value=3>Produkcja</option>
                                    <option value=2>HR</option>
                                    <option value=1>Finanse</option>
                                    <option value=4>Zarządzanie</option>
                                </select>
                            </div>
                            <div class="col-2 col-12-xsmall">
                                <input type="submit" value="Wyszukaj" class="primary button"/>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
            <section id="tabela">
                    <div class="container">
                        <h3>Tabela spisanych rzeczy</h3>
                        <table class="alt">
                            <thead>
                            <tr>
                                <th>Nr ew.</th>
                                <th>Nazwa</th>
                                <th>Producent</th>
                                <th>Model</th>
                                <th>Typ</th>
                                <th>Pokój</th>
                                <th>Dział</th>
                                <th>Szczegóły</th>
                                <th>Edytuj</th>
                                <th>Usuń</th>
                            </tr>
                            </thead>
                            <tbody>
                            {foreach $lista as $wiersz}
                                <tr>
                                    <td>{$wiersz["idprzedmiot"]}</td>
                                    <td>{$wiersz["nazwa"]}</td>
                                    <td>{$wiersz["producent"]}</td>
                                    <td>{$wiersz["model"]}</td>
                                    <td>{$wiersz["typ"]}</td>
                                    <td>{$wiersz["numer"]}</td>
                                    <td>{$wiersz["nazwadzialu"]}</td>
                                    <td style="width: 1em"><a href="{$conf->action_root}itemView/{$wiersz['idprzedmiot']}" class="button small">Wyświetl</a></td>
                                    <td style="width: 1em"><a href="{$conf->action_root}itemEdit/{$wiersz['idprzedmiot']}" class="button primary small">Edytuj</a></td>
                                    <td style="width: 1em"><a href="{$conf->action_root}itemDelete/{$wiersz['idprzedmiot']}" onclick="return confirm('Czy na pewno chcesz usunąć z ewidencji ten przedmiot?')" class="button small">Usuń</a></td>
                                </tr>
                            {/foreach}
                            </tbody>
                        </table>
                            <a type="button" class="button small" href="{if $previous_page > 0}{$conf->action_root}showMainPage/{$previous_page}{else}{$conf->action_root}showMainPage{/if}">Poprzednia strona</a>
                            <a type="button" class="button small" href="{if $isNextPage}{$conf->action_root}showMainPage/{$next_page}{/if}">Następna strona</a>
                    </div><br/>
            </section>
        </div>
        <div class="container">
            {include file='messages.tpl'}
        </div>
    </div>

{/block}
