<?php $this->load->view('header');?>

    <div class="container home" role="main">

		<div class="row">

			<div class="jumbotron">
				<?php if (!isset($current_user)): ?>
					<h3>Bemvindos ao espaço de moderação do Politikei</h3>
					<p>
						Somos uma ferramenta colaborativa com dados abertos, onde qualquer pessoa pode acessar, 
						participar e nos ajudar a construir uma nação democrática.
					</p>
					<p>
						Nós acreditamos que os cidadãos têm um papel essencial com agentes ativos na política para 
						favorecer o desenvolvimento de uma nação democrática, por isso queremos empoderá-lo e para 
						que tenham acesso controle e participação nas mudanças da política brasileira.
					</p>
					<p>
						Uma das nossas funções é selecionar os projetos que serão votados em plenário e também aqueles 
						mais polêmicos para serem disponibilizados em uma linguagem acessível e agradável ao usuário. 
						Uma vez disponibilizado, o usuário poderá votar a favor ou contra cada projeto. 
						Esse registro de opiniões nos permite gerar informações relevantes e personalizadas aos usuários.
					<p>
						Sabe como nos ajudar? 
						<a href="#register" data-toggle="modal" data-target="#registerModal">Acesse aqui</a>.
					</p>
					<p>
						Já tem um conta?
						<a href="#login" data-toggle="modal" data-target="#loginModal">Clique aqui</a>.
					</p>
					
				<?php endif;?>

			</div>

		</div>
    </div>


<?php $this->load->view('footer.php');
