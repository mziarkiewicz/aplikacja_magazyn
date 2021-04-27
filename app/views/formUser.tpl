{extends file='main.tpl'}

{block name=top}
	<!-- Main -->
		<div id="main" class="wrapper style1">
			<div class="container">
				<header class="major">
					<h2>{$page_title|default:"Aplikacja wspomagająca ewidencje sprzętu"}</h2>
					<p>{$page_description|default:""}</p>
				</header>
				<div class="row gtr-150">
					<div class="col-3 col-12-medium">
						<!-- Sidebar -->
						<section id="sidebar">
							<section>
								<h3>Instrukcja:</h3>
								<ol>
									<li>Nazwa użytkownika - powinna mieć od 2 do 20 znaków</li>
									<li>Hasło - powinno mieć od 5 do 10 znaków w tym jedną literę i jedną cyfrę</li>
									<li>Uprawnienia - wybierz jakie upr. powinien mieć użytkownik</li>
								</ol>
							</section>
						</section>
					</div>
					<div class="col-6 col-12-medium imp-medium">
						<!-- Form -->
						<section>
							<h3>{$form_description|default:"Aplikacja wspomagająca ewidencje sprzętu"}</h3>
							<form method="post" action="{$conf->action_root}userSave/">
								<div class="row gtr-uniform gtr-50">
									<input type="hidden" name="iduser" id="iduser" value="{$form->iduser}" />
									<div class="col-12">
										<input type="text" name="login" id="nazwa" value="{$form->login}" placeholder="Login" />
									</div>
									<div class="col-12">
										<input type="password" name="haslo" id="producent" value="{$form->haslo}" placeholder="Hasło" />
									</div>
									<div class="col-12 col-12-xsmall">
										<select name="idrole" id="idrole">
											<option value="">- Uprawnienia -</option>
											<option value="1">Admin</option>
											<option value="2">User</option>
										</select>
									</div>
									<div class="col-3">
										<input type="submit" value="Zapisz" class="primary" />
									</div>
									<div class="col-3">
										<a href="{$conf->action_root}" class="button">Wróć</a>
									</div>
								</form>
						</section>

						{include file='messages.tpl'}

					</div>
					<div class="col-3 col-12-medium">
						<!-- Sidebar -->
						<section id="sidebar">
						</section>
					</div>
				</div>
			</div>
		</div>
{/block}
