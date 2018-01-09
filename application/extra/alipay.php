<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017/10/31
 * Time: 上午8:49
 */
return [
    //应用对应的appID
    'app_id' => '2016082500310163',
    //公钥
    'alipay_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAjshYavjjn6Q14+SsLHai2JEbEInpw/AKIS1K1bdK8Ye6mbnONwdnqO+hrxY/Ev3fv8olgYjET6s5zZeJcqIyQtZoS7Gi809ZHnqLB0YCqx8ao4X0TDbGaO5Y8v3leyDjAmRuuUThqz3pXPplLHpawau/EaTlBqXyrvbYNb5GVgTfwN99SIM0a42QezHbwYe8fHT1/rs6qyoif/mQHgoyDLkrcjGXXlxM6lqnrOuPQJzu98+0uphOQ/JI+VxInMUDD6hNu4kfm567ttJG308KH+UrWATkmmrkEjQm6gr9KWvgFUjBN6ESr+fdh2oq8mCjizrDSVt92fWS3AF2ax1NrwIDAQAB',
    //字符集
    'charset' => 'UTF-8',
    //加密类型
    'sign_type' => 'RSA2',
    //网关地址
    'gatewayUrl' => 'https://openapi.alipaydev.com/gateway.do',
    //私钥
    'merchant_private_key' => 'MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQCOyFhq+OOfpDXj5KwsdqLYkRsQienD8AohLUrVt0rxh7qZuc43B2eo76GvFj8S/d+/yiWBiMRPqznNl4lyojJC1mhLsaLzT1keeosHRgKrHxqjhfRMNsZo7ljy/eV7IOMCZG65ROGrPelc+mUselrBq78RpOUGpfKu9tg1vkZWBN/A331IgzRrjZB7MdvBh7x8dPX+uzqrKiJ/+ZAeCjIMuStyMZdeXEzqWqes649AnO73z7S6mE5D8kj5XEicxQMPqE27iR+bnru20kbfTwof5StYBOSaauQSNCbqCv0pa+AVSME3oRKv592HairyYKOLOsNJW33Z9ZLcAXZrHU2vAgMBAAECggEAOtY4CSyyr9A9HMHYaSIiDNgOrQwHtmQt6Gn/kn3LdigWLs6wOWDlyGmm2L10FGFlWGT2e6BeNO48DYpKa2CHEZ/Erpxup5ClCrg4njCtXNKeaZADkXxo2kiNguQ5MjnlEdFNBy9pRuVmSpgsJN3ulCwvuheXANxVWuABTHQyC7OsSmSh/vYBjzBhM/xEKxRZBgCC30YQWE6Nn3LEeFgZxHkKpmvs1/ufi7lFRp1XS87jlwQ6TzF0R269/L+n3r4/NNGXGTeWvLgPz0nz52nqTrtO7PPUr3JmBF6G2/q61fedVF8MTntT0bg13PqAukLpoww6FymYtElr9W8CQ+XrAQKBgQDQzUboVrgnuP2TEPJnCoSTi/rgETicc1kvwrCNLZDP4kxNhiKVLPZWWNoJwLR/Xs1lSUIGHsev2Td1Cw9hUIs5Bp0FRGSvnlBveDDMhIqI+dkMuB3jw2MShN7en5KRFBhUZxUeVBT9n70WAnNt9T0i0oeY3meKo/Y+Z8cp0nqUwQKBgQCvDrx3j/Jw4he2PYxVCoB1EwsJNV+80F5mbPjkgAFkeSc9XZQC233kwNqHXOZpkKWDEO6f4hjlAsnKs+kss7OUqAZMNioH3Xdu7SX4JuET9YQ+2h4U9kiCykfFqQpgvUcT0snb5vtxcHB5xvmHKF44Emn5YJXgw+IrRHr9Q6RObwKBgQCuG/4cjvNQbDlGAMOgmGyke/zeCn4iNy0PXlDJ6Ezwi8sEee0sZymiJsTpjP71lp++7a9YWyI3x/Eub+KLSxZMnu8gDT/IEUMRMC/A2mSKg4wxxvVlju916cXN7VHSF+eRucMqXwKB2klZqQGHlw87kkHvfsToHoCe2PqCLTh6AQKBgQCg2j6M8iTIWseE+fsHbTXp3Yyncna87Q3AueLdO02MP9KxjVniYkLEvfxOoytI1tNuolFRchSD4dL/wd7A54JcVyQqRR7LyVDkCV55LWhlyZQxmIRJqJ+qJipa0l+p0mIMMgSvXgevDa0cCJvh+FLS3QCpV3mAZR1dunf0XYINWwKBgBymwyDAA5fXtFBChglCPam6a+835ou8FLCKPVfO6Hzp5uvmVolQSVAJFzY/uLQMAfwVHVOnWPPSRQBKiQ3NIx4YLMKXZRyPAsZXOZQBJNPjt3+XzhSkxeNXRYvQV6yNOpnvOzKpUvgp60Qr9ir4sdmPWHZpZNesuHp069v1L6/y',
    //服务器回调地址
    'notify_url' => 'http://business.local/index/notify/index',
    //前端跳转地址 不能带任何参数
    'return_url' => 'http://business.local/index/order/finish_front'
];