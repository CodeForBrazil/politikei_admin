<?php $this->load->view('header');?>

    <div class="container home" role="main">

		<div class="row">

			<div class="jumbotron">
			
				<h3>Bem vindos ao espaço de moderação do Politikei</h3>
				<p>
					Somos uma ferramenta colaborativa com dados abertos, onde qualquer pessoa pode acessar, 
					participar e nos ajudar a construir uma nação democrática.
				</p>
				<p>
					Nós acreditamos que os cidadãos têm um papel essencial com agentes ativos na política para 
					favorecer o desenvolvimento de uma nação democrática, por isso queremos empoderá-lo e para 
					que tenham acesso controle e participação nas mudanças da política brasileira.
				</p>

				<h4> Como fazer parte do Politikei sendo um colaborador de proposições?</h4>

				<p>
					Para facilitar a sua colaboração, desenvolvemos um portal exclusivo onde você pode ver as 
					proposições que necessitam ser resumidas, acessar suas informações, reservá-las antes de 
					começar a produzi-las (para que ninguém faça trabalho em vão), e submeter o resumo realizado.
				</p>

				<h4>Qual formato deve ser o resumo?</h4>
			
				<p>
					O resumo deve ser de linguagem simples e clara, autoexplicativo, que contenha de forma direta 
					todas as informações de uma proposição expostas em ordem de relevância, para gerar envolvimento 
					e agilidade aos usuários.
				</p>

				<p>
					É de suma importância IMPARCIALIDADE na produção de um resumo, ou seja, não se deve emitir qualquer
				 	juízo de valor ou manipular as informações tornando-as tendenciosas. Estamos trabalhando juntos para
				 	 empoderar os cidadãos tornando-os agentes transformadores, e não para influenciá-los de nossas opiniões.
			 	 </p>

				<h4>Por que devo preencher 2 campos para submeter um resumo?</h4>

				<p>
					O primeiro (menor) está destinado a um “título” para a proposição que, em poucas palavras, identifique 
					aos usuários de qual proposição estamos nos referindo.
				</p>

				<p>
					O segundo (maior) está destinado ao resumo propriamente dito.
				</p>

				<h4>Dúvidas, críticas, sugestões?</h4>

				<p>
					Nunca se esqueça de que trabalhamos de forma aberta e colaborativa, por isso é muito importante para nós 
					recebermos todo tipo de opiniões. E caso queira participar de forma ainda mais ativa, fale com a gente!
				</p>

				<h4>Comece agora mesmo!</h4>

				<ol>
					<?php if (!isset($current_user)): ?>
						<li><a href="#register" data-toggle="modal" data-target="#registerModal">Cadastre-se</a>. em nosso portal.
						Já tem conta?<a href="#login" data-toggle="modal" data-target="#loginModal"> Clique aqui</a>.</li>
					<?php endif;?>
					<li>Escolha uma proposição disponível para resumi-la.</li>
					<li>Reserve a proposição.</li>
					<li>Produza o “título” e o resumo.</li>
					<li>Submeta-os pelo portal. </li>
				</ol>



			</div>

		</div>
    </div>


<?php $this->load->view('footer.php');