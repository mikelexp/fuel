<?

namespace Tests;

use Asset;
use Fuel\Core\Cli;
use Fuel\Core\DBUtil;
use Fuel\Core\Fuel;
use Fuel\Core\Input;
use Fuel\Core\Migrate;
use Fuel\Core\Pagination;
use Fuel\Core\Uri;
use Fuel\Core\View;
use Log;
use Mkappconfig\Mkappconfig;
use Mkauth\Mkauth;
use Mkauth\MkauthException;
use Mkbrowserphp\Mkbrowserphp;
use Mkcart\Mkcart;
use Mkcart\Mkcartcupon;
use Mkcart\Mkcartitem;
use Mkemailqueue\Mkemailqueue;
use Mksmtpclient\Mksmtpclient;
use Mksmtpclient\MksmtpclientException;
use Mkswf\Mkswf;

class Controller_Tests extends \Controller_Frontend {

	function action_index() {
		echo "Tests";
	}

	function action_swift() {

		$message = \Swift_Message::newInstance()

		->setCharset("utf-8")
		->setSubject("Test subject")
		->setFrom("info@info.com", "Swift Mailer Test")
		->setTo(array("info@info.com", "info2@info.com"))
		->setBody("Hola!");

		$transport = \Swift_MailTransport::newInstance();

		$mailer = \Swift_Mailer::newInstance($transport);

		$mails_enviados = $mailer->send($message);

		echo "Mails enviados: {$mails_enviados}";

	}

	function action_auth() {
		Mkauth::initialize("mkauth_frontend");
		try {
			$usuario = Mkauth::login("test@test.com", "admin");
			if ($usuario) {
				echo "Ok! {$usuario->nombre}";
				echo Mkauth::get_user()->nombre;
			} else {
				echo "Error!";
			}
		} catch (MkauthException $ex) {
			echo $ex->getMessage();
		}
	}

	function action_mig() {
		Migrate::latest();
	}

	function action_pag() {

		$pag = Pagination::forge("default", array(
			"pagination_url" => Uri::current(),
			"total_items" => 100,
			"per_page" => 10,
			"num_links" => 5,
			"show_first" => true,
			"show_last" => true,
			"uri_segment" => "pagina"
		));

		echo Input::get("pagina")."<br />";
		echo $pag->render();

	}

	function action_bphp() {

		$bp = new Mkbrowserphp;
		$bp->log("Hoya!");
		$bp->error("Todo mal");
		$bp->group_start("boludeces");
		$bp->info("Just for your info");
		$bp->warn("Hey warn dude!");
		$bp->group_end();

	}

	function action_orm() {

		DBUtil::truncate_table("categorias");
		DBUtil::truncate_table("productos");

		$televisores = new \Model_Categoria;
		$televisores->nombre = "Televisores";
		$televisores->activo = true;
		$televisores->save();

		$lavarropas = new \Model_Categoria;
		$lavarropas->nombre = "Lavarropas";
		$lavarropas->activo = true;
		$lavarropas->save();

		$televisor_samsung = new \Model_Producto;
		$televisor_samsung->categoria = $televisores;
		$televisor_samsung->nombre = "Samsung LN32C550";
		$televisor_samsung->activo = true;
		$televisor_samsung->save();

		$televisor_sony = new \Model_Producto;
		$televisor_sony->categoria = $televisores;
		$televisor_sony->nombre = "Sony HZ221";
		$televisor_sony->activo = true;
		$televisor_sony->save();

		$lavarropas_drean = new \Model_Producto;
		$lavarropas_drean->categoria = $lavarropas;
		$lavarropas_drean->nombre = "Drean Unicommand 101";
		$lavarropas_drean->activo = true;
		$lavarropas_drean->save();

		$televisores->delete(true);

	}

	function action_eq() {
		$eq = Mkemailqueue::forge();
		$eq->from("miguel@mikele.net", "Miguel Scaramozzino")->to("miguel@bajocero.in");
		$eq->subject("Mkemailqueue for FuelPHP Test");
		$eq->prioritario()->message_html("Texto HTML")->message_plain("Texto PLAIN")->save();
		$eq->send();
	}

	function action_phpstorm() {
		if (Fuel::$is_cli) {
			Cli::write("Bananeitor!");
		}
	}

	function action_less() {
		echo \Asset::less("base.less");
		echo \Asset::render();
	}

	function action_log() {
		Log::info("Este es un info");
		Log::error("Upa jodido!");
	}

	function action_swf() {
		$this->template->body = Mkswf::swf(Asset::swf("fotolog.swf"), "swf_test", 250, 200, "div", 10, array(), array(), true);
		return $this->response();
	}

	function action_appconfig() {
		Mkappconfig::set("sexo", "Indefinido");
		echo Mkappconfig::get("sexo");
		Mkappconfig::delete("sexo");

		Mkappconfig::set("fruta", "Banana", "session");
		echo Mkappconfig::get("fruta", null, false, "session");
	}

	function action_orm2() {

		DBUtil::truncate_table("posts");
		DBUtil::truncate_table("posts_comentarios");
		DBUtil::truncate_table("posts_tags");
		DBUtil::truncate_table("tags");
		DBUtil::truncate_table("usuarios");

		$tag_musica = new \Model_Tag;
		$tag_musica->tag = "musica";
		$tag_musica->activo = true;
		$tag_musica->save();

		$tag_metal = new \Model_Tag;
		$tag_metal->tag = "metal";
		$tag_metal->activo = true;
		$tag_metal->save();

		$usuario_juan = new \Model_Usuario;
		$usuario_juan->nombre = "Juan";
		$usuario_juan->apellido = "Perez";
		$usuario_juan->activo = true;
		$usuario_juan->save();

		$usuario_pepe = new \Model_Usuario;
		$usuario_pepe->nombre = "Pepe";
		$usuario_pepe->apellido = "Gomez";
		$usuario_pepe->activo = true;
		$usuario_pepe->save();

		$post_1 = new \Model_Post;
		$post_1->usuario = $usuario_juan;
		$post_1->titulo = "Post 1";
		$post_1->tags = array($tag_musica, $tag_metal);
		$post_1->activo = true;
		$post_1->save();

		$post_2 = new \Model_Post;
		$post_2->usuario = $usuario_pepe;
		$post_2->titulo = "Post 2";
		$post_2->tags[] = $tag_musica;
		$post_2->activo = true;
		$post_2->save();

		$comentario_1 = new \Model_Post_Comentario;
		$comentario_1->post = $post_1;
		$comentario_1->usuario = $usuario_juan;
		$comentario_1->texto = "Comentario al Post 1";
		$comentario_1->activo = true;
		$comentario_1->save();

		$usuarios = \Model_Usuario::query();
		$usuarios->related("posts", array("where" => array(array("activo", 1))));
		$usuarios->related("posts.tags");
		$usuarios->related("posts.comentarios", array("where" => array(array("activo", 1))));
		$data['usuarios'] = $usuarios->get();

		$this->template->body = View::forge("usuarios", $data);
		return $this->response();

	}

	function action_cart() {

		\Package::load("mkcart");

		Mkcart::clear();

		// agregar items
		Mkcart::add_item(new Mkcartitem(10, "Televisor", "Desc", 1, 1500));
		Mkcart::add_item(new Mkcartitem(20, "Calefactor", "Desc", 1, 3000));
		Mkcart::add_item(new Mkcartitem(30, "Lavarropas", "Desc", 1, 3000));

		// actualizar cantidad
		$lavarropas = Mkcart::item(3);
		$lavarropas->quantity = 5;
		Mkcart::update_item($lavarropas);

		// se agrega un item por segunda vez
		$televisor = new Mkcartitem(10, "Televisor--2", "Desc--2", 2, 1500);
		Mkcart::add_item($televisor, true);

		// borrar un item
		Mkcart::delete_item(Mkcart::item(2));

		// agregar cupon
		Mkcart::add_cupon(new Mkcartcupon(null, "ABC123", null, 10, null));
		Mkcart::add_cupon(new Mkcartcupon(null, "ABC123", null, null, 550));

		// borrar cupon
		Mkcart::delete_cupon(Mkcart::cupon(2));

		$data['cart'] = Mkcart::cart();

		$this->template->body = View::forge("mkcart", $data);
		return $this->response();

	}

	function action_cart2() {

		\Package::load("mkcart");

		Mkcart::clear();

		$lava = new Mkcartitem;
		$lava->external_id(1);
		$lava->quantity(1);
		$lava->price(1000);
		$lava->name("Lavarropas");
		$lava->add();

		$lava = new Mkcartitem;
		$lava->external_id(1);
		$lava->quantity(1);
		$lava->price(1000);
		$lava->name("Lavarropas");
		$lava->add();

		$lava = new Mkcartitem;
		$lava->external_id(1);
		$lava->quantity(1);
		$lava->price(1000);
		$lava->name("Lavarropas");
		$lava->add(true);

		$data['cart'] = Mkcart::cart();

		$this->template->body = View::forge("mkcart", $data);
		return $this->response();

	}

	public function action_smtp() {

		\Package::load("mksmtpclient");

		try {
			Mksmtpclient::forge()
				->host("ssl://smtp.gmail.com")->port(465)
				->user("miguel@bajocero.in")->password("sinasunto")
				->from("miguel@bajocero.in", "From Miguel")
				->to("miguel@bajocero.in", "To 1")
				->to("contacto@bajocero.in", "To 2")
				->cc("miguel@bajocero.in", "Cc 1")
				->cc("contacto@bajocero.in", "Cc 2")
				->bcc("miguel@bajocero.in", "Bcc 1")
				->bcc("contacto@bajocero.in", "Bcc 2")
				->subject("Mksmtpclient Testing")
				->message("Test")
				->header("X-Mailer", "bajocero-mailer")
				->send();
		} catch (MksmtpclientException $ex) {
			echo $ex->getMessage();
		}

	}

	public function action_twig() {
		\Package::load("parser");
		$data['titulo'] = "My Twig";
		$data['items'] = array("Uno", "Dos", "Tres");
		return \View::forge("twig.twig", $data);
	}

}
