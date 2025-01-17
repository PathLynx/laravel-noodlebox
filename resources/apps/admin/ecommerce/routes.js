import ProductList from "./ProductList";
import ProductEdit from "./ProductEdit";
import FreightTemplateList from "./FreightTemplateList";
import FreightTemplateEdit from "./FreightTemplateEdit";
import RefundAddress from "./RefundAddress";
import RefundReason from "./RefundReason";
import Coupon from "./Coupon";
import AttributeList from "./AttributeList.vue";
import VariationList from "./VariationList.vue";
import ShippingZoneList from "./ShippingZoneList.vue";
import ShopList from "./ShopList.vue";
import ShopEdit from "./ShopEdit.vue";
import PhotoWall from "./PhotoWall.vue";
import DeliveryerList from "./DeliveryerList.vue";
import OrderList from "./OrderList.vue";
import OrderDetail from "./OrderDetail.vue";
import PosMachineList from "./PosMachineList.vue";
import Settings from "./Settings.vue";
import CashierTransaction from "./CashierTransaction.vue";
import DeliveryerTransaction from "./DeliveryerTransaction.vue";

module.exports = [
    {path: '/product/list', component: ProductList, meta: {title: '商品管理'}},
    {path: '/product/new', component: ProductEdit, meta: {title: '添加商品'}},
    {path: '/product/edit/:id?', component: ProductEdit, meta: {title: '编辑商品'}},
    {path: '/product/attributes', component: AttributeList, meta: {title: '产品型号'}},
    {path: '/product/variations', component: VariationList, meta: {title: '产品变量'}},
    {path: '/refund/address', component: RefundAddress, meta: {title: '退货地址'}},
    {path: '/refund/reason', component: RefundReason, meta: {title: '退货理由'}},
    {path: '/coupon/list', component: Coupon, meta: {title: '优惠券管理'}},
    {path: '/product/attributes', component: AttributeList, meta: {title: '产品型号'}},
    {path: '/product/variations', component: VariationList, meta: {title: '产品变量'}},
    {path: '/freight-template/list', component: FreightTemplateList, meta: {title: '运费模板'}},
    {path: '/freight-template/edit/:id?', component: FreightTemplateEdit, meta: {title: '编辑模板'}},
    {path: '/shipping-zone/list', component: ShippingZoneList, meta: {title: '配送区域'}},
    {path: '/shop/list', component: ShopList, meta: {title: '门店管理'}},
    {path: '/shop/new', component: ShopEdit, meta: {title: '新增门店'}},
    {path: '/shop/edit/:id?', component: ShopEdit, meta: {title: '编辑门店'}},
    {path: '/photo-wall', component: PhotoWall, meta: {title: '照片墙'}},
    {path: '/deliveryers', component: DeliveryerList, meta: {title: '配送员管理'}},
    {path: '/order/list', component: OrderList, meta: {title: '订单管理', group: 'trade'}},
    {path: '/order/detail/:id?', component: OrderDetail, meta: {title: '订单详情', group: 'trade'}},
    {path: '/pos-machines', component: PosMachineList, meta: {title: 'POS管理', group: 'trade'}},
    {path: '/shop/settings', component: Settings, meta: {title: '店铺设置', group: 'trade'}},
    {path: '/cashier/transactions', component: CashierTransaction, meta: {title: '收银台账', group: 'trade'}},
    {path: '/deliveryer/transactions', component: DeliveryerTransaction, meta: {title: '司机台账', group: 'trade'}},
]
