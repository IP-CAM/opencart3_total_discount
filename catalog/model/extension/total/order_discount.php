<?php
class ModelExtensionTotalOrderDiscount extends Model {
	public function getTotal($total) {
		$this->load->language('extension/total/order_discount');

		$total_discount = 0;
		$value = 0;
		$total_taxes = array_sum($this->cart->getTaxes());
		$total_quantity_cart =  $this->cart->countProducts();

		$total_sub_total = $total_taxes ? $this->cart->getSubTotal() + $total_taxes : $this->cart->getSubTotal();
		//change percents
		foreach(explode(',', $this->config->get('total_order_discount_totals')) as $data) {
			$data = explode(':', $data);
			if ($data[0] >= $total_sub_total) {
				if (isset($data[1])) {
					$value = $data[1];
				}
				break;
			}
		}

				
		$total_discount = $total_sub_total * $value / 100;
				
			
		

		if ($total_discount > 0) {
			$total['totals'][] = array(
				'code'       => 'order_discount',
				'title'      => $this->language->get('text_total_order_discount_discount'),
				'value'      => $total_discount,
				'sort_order' => $this->config->get('total_order_discount_sort_order')
			);

			$total['total'] -= $total_discount;
		}
	}
}
