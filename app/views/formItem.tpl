{extends file='main.tpl'}

{block name=top}
	<!-- Main -->
		<div id="main" class="wrapper style1">
			<div class="container">
				<header class="major">
					<h2>{$page_title|default:"Aplikacja wspomagająca ewidencje sprzętu"}</h2>
					<p>{$page_description|default:"Aplikacja wspomagająca ewidencje sprzętu"}</p>
				</header>
				<div class="row gtr-150">
					<div class="col-4 col-12-medium">
						<!-- Sidebar -->
						<section id="sidebar">
							<section>
								<h3>Instrukcja:</h3>
								<ol>
									<li>Nazwa urządzenia - powinna mieć od 2 do 20 znaków</li>
									<li>Marka / Nazwa producenta - powinna mieć od 2 do 20 znaków</li>
									<li>Model - powinien mieć od 2 do 10 znaków</li>
									<li>Wpisz typ urządzenia/sprzętu - powinien mieć od 2 do 20 znaków</li>
									<li>Nr pokoju - wprowadź pokój w którym znajduje się urządzenie</li>
								</ol>
							</section>
						</section>
					</div>
					<div class="col-8 col-12-medium imp-medium">
						<!-- Form -->
						<section>
							<h3>{$form_title|default:"Brak tytułu"}</h3>
							<form method="post" action="{$conf->action_root}itemSave/">
								<div class="row gtr-uniform gtr-50">
									<input type="hidden" name="idprzedmiot" id="idprzedmiot" value="{$form->idprzedmiot}" />
									<div class="col-12">
										<input type="text" name="nazwa" id="nazwa" value="{$form->nazwa}" placeholder="Nazwa" />
									</div>
									<div class="col-12">
										<input type="text" name="producent" id="producent" value="{$form->producent}" placeholder="Producent" />
									</div>
									<div class="col-12">
										<input type="text" name="modelurz" id="modelurz" value="{$form->modelurz}" placeholder="Model" />
									</div>
									<div class="col-12">
										<input type="text" name="typ" id="typ" value="{$form->typ}" placeholder="Typ" />
									</div>
									<div class="col-12 col-12-xsmall">
										<select name="idpomieszczenie" id="idpomieszczenie">
											<option value="">- Nr pokoju -</option>
											<option value="1">101</option>
											<option value="2">102</option>
											<option value="3">201</option>
											<option value="4">202</option>
											<option value="5">301</option>
											<option value="6">302</option>
											<option value="8">401</option>
											<option value="7">402</option>
										</select>
									</div>
									<div class="col-12">
										<input type="submit" value="Zapisz" class="primary" />
										<a href="{$conf->action_root}" class="button">Wróć</a>
									</div>
								</form>
						</section>

						{include file='messages.tpl'}

					</div>
				</div>
			</div>
		</div>
{/block}
