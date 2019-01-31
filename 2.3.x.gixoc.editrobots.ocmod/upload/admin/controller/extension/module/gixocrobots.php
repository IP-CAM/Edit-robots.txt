<?php
class ControllerExtensionModuleGixocrobots extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/gixocrobots');

		$this->document->setTitle($this->language->get('text_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if(isset($this->request->post['robots'])){
				$file = str_replace("system/", "", DIR_SYSTEM) . 'robots.txt';

				$handles = fopen($file, 'w+'); 

				$robots = str_replace("&amp;", "&", $this->request->post['robots']);
                
				fwrite($handles, $robots);

				fclose($handles); 
				
				$this->session->data['success'] = $this->language->get('text_success');
				
				$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
			}
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');

		$data['entry_create'] = $this->language->get('entry_create');
		$data['entry_clean'] = $this->language->get('entry_clean');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_title'),
			'href' => $this->url->link('extension/module/gixocrobots', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/module/gixocrobots', 'token=' . $this->session->data['token'], true);
		
		$data['cancel'] = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true);

		$data['text'] = '';

		$file = str_replace("system/", "", DIR_SYSTEM) . 'robots.txt';

		if (file_exists($file)) {
			$data['text'] = file_get_contents($file, FILE_USE_INCLUDE_PATH, null);
		} 

		$data['token'] = $this->session->data['token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
		$this->response->setOutput($this->load->view('extension/module/gixocrobots', $data));
	}

	public function getUrl($route){
		$url = new Url(HTTP_CATALOG, $this->config->get('config_secure') ? HTTP_CATALOG : HTTPS_CATALOG);
		if ($this->config->get('config_seo_url')) {
            require_once(DIR_CATALOG . 'controller/startup/seo_url.php');
            $rewriter = new ControllerStartupSeoUrl($this->registry);
            $url->addRewrite($rewriter);
		}
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$domain = HTTPS_CATALOG;
		} else {
			$domain = HTTP_CATALOG;
		}
		
		return str_replace($domain, "", $url->link($route));
	}

	public function create_robots(){
		$text = "User-agent: *
Disallow: /" . $this->getUrl("account/account") . "
Disallow: /" . $this->getUrl("account/address") . "
Disallow: /" . $this->getUrl("account/download") . "
Disallow: /" . $this->getUrl("account/edit") . "
Disallow: /" . $this->getUrl("account/forgotten") . "
Disallow: /" . $this->getUrl("account/login") . "
Disallow: /" . $this->getUrl("account/logout") . "
Disallow: /" . $this->getUrl("account/newsletter") . "
Disallow: /" . $this->getUrl("account/order") . "
Disallow: /" . $this->getUrl("account/password") . "
Disallow: /" . $this->getUrl("account/recurring") . "
Disallow: /" . $this->getUrl("account/register") . "
Disallow: /" . $this->getUrl("account/return") . "
Disallow: /" . $this->getUrl("account/reward") . "
Disallow: /" . $this->getUrl("account/success") . "
Disallow: /" . $this->getUrl("account/transaction") . "
Disallow: /" . $this->getUrl("account/voucher") . "
Disallow: /" . $this->getUrl("account/wishlist") . "
Disallow: /" . $this->getUrl("affiliate/account") . "
Disallow: /" . $this->getUrl("affiliate/edit") . "
Disallow: /" . $this->getUrl("affiliate/forgotten") . "
Disallow: /" . $this->getUrl("affiliate/login") . "
Disallow: /" . $this->getUrl("affiliate/logout") . "
Disallow: /" . $this->getUrl("affiliate/password") . "
Disallow: /" . $this->getUrl("affiliate/payment") . "
Disallow: /" . $this->getUrl("affiliate/register") . "
Disallow: /" . $this->getUrl("affiliate/success") . "
Disallow: /" . $this->getUrl("affiliate/tracking") . "
Disallow: /" . $this->getUrl("affiliate/transaction") . "
Disallow: /" . $this->getUrl("checkout/cart") . "
Disallow: /" . $this->getUrl("checkout/checkout") . "
Disallow: /" . $this->getUrl("checkout/failure") . "
Disallow: /" . $this->getUrl("checkout/success") . "
Disallow: /" . $this->getUrl("product/compare") . "
Disallow: /" . $this->getUrl("product/search") . "
Disallow: /index.php?route=product/product*&manufacturer_id=
Disallow: /admin
Disallow: /catalog
Disallow: /system
Disallow: /*?sort=
Disallow: /*&sort=
Disallow: /*?order=
Disallow: /*&order=
Disallow: /*?limit=
Disallow: /*&limit=
Disallow: /*?filter=
Disallow: /*&filter=
Disallow: /*?filter_name=
Disallow: /*&filter_name=
Disallow: /*?filter_sub_category=
Disallow: /*&filter_sub_category=
Disallow: /*?filter_description=
Disallow: /*&filter_description=
Disallow: /*?tracking=
Disallow: /*&tracking=
Allow: /catalog/view/javascript/
Allow: /catalog/view/theme/*/

User-agent: Yandex
Disallow: /" . $this->getUrl("account/account") . "
Disallow: /" . $this->getUrl("account/address") . "
Disallow: /" . $this->getUrl("account/download") . "
Disallow: /" . $this->getUrl("account/edit") . "
Disallow: /" . $this->getUrl("account/forgotten") . "
Disallow: /" . $this->getUrl("account/login") . "
Disallow: /" . $this->getUrl("account/logout") . "
Disallow: /" . $this->getUrl("account/newsletter") . "
Disallow: /" . $this->getUrl("account/order") . "
Disallow: /" . $this->getUrl("account/password") . "
Disallow: /" . $this->getUrl("account/recurring") . "
Disallow: /" . $this->getUrl("account/register") . "
Disallow: /" . $this->getUrl("account/return") . "
Disallow: /" . $this->getUrl("account/reward") . "
Disallow: /" . $this->getUrl("account/success") . "
Disallow: /" . $this->getUrl("account/transaction") . "
Disallow: /" . $this->getUrl("account/voucher") . "
Disallow: /" . $this->getUrl("account/wishlist") . "
Disallow: /" . $this->getUrl("affiliate/account") . "
Disallow: /" . $this->getUrl("affiliate/edit") . "
Disallow: /" . $this->getUrl("affiliate/forgotten") . "
Disallow: /" . $this->getUrl("affiliate/login") . "
Disallow: /" . $this->getUrl("affiliate/logout") . "
Disallow: /" . $this->getUrl("affiliate/password") . "
Disallow: /" . $this->getUrl("affiliate/payment") . "
Disallow: /" . $this->getUrl("affiliate/register") . "
Disallow: /" . $this->getUrl("affiliate/success") . "
Disallow: /" . $this->getUrl("affiliate/tracking") . "
Disallow: /" . $this->getUrl("affiliate/transaction") . "
Disallow: /" . $this->getUrl("checkout/cart") . "
Disallow: /" . $this->getUrl("checkout/checkout") . "
Disallow: /" . $this->getUrl("checkout/failure") . "
Disallow: /" . $this->getUrl("checkout/success") . "
Disallow: /" . $this->getUrl("product/compare") . "
Disallow: /" . $this->getUrl("product/search") . "
Disallow: /index.php?route=product/product*&manufacturer_id=
Disallow: /admin
Disallow: /catalog
Disallow: /system
Disallow: /*?sort=
Disallow: /*&sort=
Disallow: /*?order=
Disallow: /*&order=
Disallow: /*?limit=
Disallow: /*&limit=
Disallow: /*?filter=
Disallow: /*&filter=
Disallow: /*?filter_name=
Disallow: /*&filter_name=
Disallow: /*?filter_sub_category=
Disallow: /*&filter_sub_category=
Disallow: /*?filter_description=
Disallow: /*&filter_description=
Disallow: /*?tracking=
Disallow: /*&tracking=
Allow: /catalog/view/javascript/
Allow: /catalog/view/theme/*/
Clean-param: tracking";

		$this->response->setOutput($text);
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/gixocrobots')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}