-- phpMyAdmin SQL Dump
-- version 3.3.7
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2016 年 05 月 20 日 17:51
-- 服务器版本: 5.1.63
-- PHP 版本: 5.2.17p1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `db_wxmbht`
--

-- --------------------------------------------------------

--
-- 表的结构 `act_function`
--

CREATE TABLE IF NOT EXISTS `act_function` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '功能名称',
  `path` varchar(255) DEFAULT NULL COMMENT '链接',
  `is_show` int(1) DEFAULT '1' COMMENT '是否显示(0-不显示,1-显示)',
  `parent_id` int(11) DEFAULT NULL COMMENT '上一级权限',
  `order_no` int(11) DEFAULT NULL COMMENT '排序号',
  `is_usable` int(1) DEFAULT '1' COMMENT '是否可用(0-不可用,1-可用)',
  `func_type` varchar(10) DEFAULT NULL COMMENT '功能类别',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='功能表' AUTO_INCREMENT=133 ;

--
-- 转存表中的数据 `act_function`
--

INSERT INTO `act_function` (`id`, `name`, `path`, `is_show`, `parent_id`, `order_no`, `is_usable`, `func_type`) VALUES
(1, '用户管理', '', 1, 0, 1, 1, ''),
(2, '系统设置', '', 1, 0, 10, 1, NULL),
(3, '订单管理', NULL, 1, 0, 2, 1, NULL),
(4, '券码管理', '', 1, 0, 3, 1, NULL),
(7, '用户列表', 'Home/App/index', 1, 1, 1, 1, NULL),
(28, '添加权限', 'Home/Action/pow_opt', 1, 2, 1, 1, NULL),
(29, '功能列表', 'Home/Action', 1, 2, 2, 1, NULL),
(30, '权限列表', 'Home/Action/pow_list', 1, 2, 3, 1, NULL),
(125, '订单列表', 'Home/Order/index', 1, 3, 1, 1, NULL),
(126, '券码列表', 'Home/Coupon/index', 1, 4, 1, 1, NULL),
(127, '管理员列表', 'Home/User/index', 1, 2, 0, 1, NULL),
(128, '添加系统用户', 'Home/User/add', 1, 2, 0, 1, NULL),
(129, '课程管理', '', 1, 0, 4, 1, NULL),
(130, '课程列表', 'Home/Project/index', 1, 129, 0, 1, NULL),
(131, '添加课程', 'Home/Project/add', 1, 129, 1, 1, NULL),
(132, '排课列表', 'Home/Bespoke/index', 1, 129, 0, 1, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `act_pow`
--

CREATE TABLE IF NOT EXISTS `act_pow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pow_name` varchar(50) NOT NULL COMMENT '权限名',
  `data` text NOT NULL COMMENT '数据',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='权限关联表' AUTO_INCREMENT=35 ;

--
-- 转存表中的数据 `act_pow`
--

INSERT INTO `act_pow` (`id`, `pow_name`, `data`) VALUES
(1, '系统管理员', '1,7,3,125,4,126,129,132,130,131,2,128,127,28,29,30'),
(32, '前台', '1,7,3,125,4,126'),
(33, '运营', '1,7,3,125,4,126,129,132,130,131'),
(34, '校区维度权限', '129,132');

-- --------------------------------------------------------

--
-- 表的结构 `act_user_pow`
--

CREATE TABLE IF NOT EXISTS `act_user_pow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(50) DEFAULT NULL COMMENT '系统用户编号',
  `pow_id` int(11) DEFAULT NULL COMMENT '权限编号',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户权限关联表' AUTO_INCREMENT=88 ;

--
-- 转存表中的数据 `act_user_pow`
--

INSERT INTO `act_user_pow` (`id`, `user_id`, `pow_id`) VALUES
(1, '1', 1),
(58, '21ADAEC9-C4A0-F17A-0B2F-B6C068416B0D', 1),
(59, '4327D32B-9368-11D4-246A-6E3B862EA534', 1),
(60, 'E8AE3CDC-957D-7B93-CDA4-386E468B2E13', 1),
(61, '60A7CBFC-DDCE-D25B-7022-9928905CCE57', 32),
(62, '7D7F9E78-6F41-5283-F27E-E994B1D3D6E0', 32),
(63, '06B4FEE7-529A-9677-6CC0-144A0F4EB221', 32),
(64, 'C7F178D5-7AE3-0596-C40F-94241A670BF5', 32),
(65, '8DA44262-CFCA-71EF-CBFC-7F88C123BEDE', 32),
(66, 'B132F726-A3BD-F56C-C5C4-7ED951FD71D5', 32),
(67, '5CF8E04D-7B55-81DD-2B20-B5CE9D0DF4C8', 32),
(68, 'D33545D8-B19A-7890-DE96-786C8A1C0198', 32),
(69, '0C2B41FC-43DE-15CB-DF39-4196E9533448', 32),
(70, 'A06B2708-5C8A-4B2A-C787-EBE814EBDFA2', 32),
(71, 'E2E456D3-4DFB-A2B5-ED7B-6A0550A2AF67', 32),
(72, '4472FA40-170F-B048-C299-53331844EFB8', 32),
(73, '1A030DD4-6C7D-121C-5756-75BD4940CDC8', 32),
(74, '009F69A3-3B59-026F-1A73-EF7216B52EE2', 32),
(75, 'F92FCEA8-FB47-8C1D-572C-D52A1509B67A', 32),
(76, '16B420CC-A676-7106-18B2-3846F3F9B4A1', 32),
(77, '8F8B00A6-F58D-9022-93E9-1A5CD5C0E05C', 32),
(78, '7CA69BAD-E7F8-4F89-1717-2B38864405BF', 32),
(79, 'DAD73A4E-56B4-5E7C-0215-7C368BA3D853', 32),
(80, 'D4FE86EF-5187-839E-774A-00115BCD4F54', 32),
(81, 'C3B2DBF1-0C31-CF0B-EFC9-F7DD6126E88F', 32),
(82, '8A7D96FC-FEE5-06D8-F87A-66718163C032', 32),
(83, '562BADA3-EFA2-C172-04EC-4191E4B9AA56', 32),
(84, 'D9BEBED2-CB30-B259-6C6F-D101001A18E5', 32),
(85, '56BD5D6A-6D7A-3014-70AD-69083DC459B2', 33),
(86, '2E33A0D0-6698-7D31-BC45-3E956129E32A', 33),
(87, '5821763E-858E-6DEF-5E55-2F26C52EED35', 33);

-- --------------------------------------------------------

--
-- 表的结构 `yes_app`
--

CREATE TABLE IF NOT EXISTS `yes_app` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `phone` varchar(50) NOT NULL COMMENT '手机号',
  `nickname` varchar(50) DEFAULT NULL COMMENT '用户名(昵称)',
  `headimgurl` varchar(500) DEFAULT NULL COMMENT '头像链接',
  `openid` varchar(50) DEFAULT NULL,
  `invitatiom` varchar(50) DEFAULT '0' COMMENT '邀请函页',
  `invi_people` varchar(50) DEFAULT NULL COMMENT '邀请人(id)',
  `project_id` int(11) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `invi_people` (`invi_people`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户表' AUTO_INCREMENT=175 ;

--
-- 转存表中的数据 `yes_app`
--

INSERT INTO `yes_app` (`id`, `phone`, `nickname`, `headimgurl`, `openid`, `invitatiom`, `invi_people`, `project_id`, `create_time`) VALUES
(89, '15801269933', '高小高', 'http://wx.qlogo.cn/mmopen/mic2icHcXUtBnvg7cEjjxu6OzicFDuF9yJbU7KyMauVCtR2raqfPZcVbnHgOJzSoKEvGXc3ZQpa8WwzNqibXE1T3qQGicbeWSxMGZ/0', 'odavgswf1aflx3xXoX9Fe6qpzGOs', '0', '73', 1, '2016-05-17 14:33:01'),
(90, '15201503042', 'A', 'http://wx.qlogo.cn/mmopen/UKtKwnNOk7wSOibtYwfiayK8WhbxQ2EdWgibb01Pu4ktpqV368rvXBSDaq4AAtRfnNozYIvh0XQibfuUWaKThW2fOvOMzcmS60yD/0', 'odavgsyEKFHmbe_2u_snUXV7sqe0', '1', '86', 1, '2016-05-17 14:34:18'),
(86, '15011551987', '吉吉', 'http://wx.qlogo.cn/mmopen/umYhnlBASpyl06et73lggu6kloX7mxYyaKd1FEtLmjQWFDIAR5oLkMIVybjxo2ukwlWquN3Ckuic6VtfMMq1BrO3BfI8iaajch/0', 'odavgs1TYUAS94g9I7nsdHG4Atwk', '1', '72', 1, '2016-05-17 14:26:27'),
(85, '13366049692', '大木木。', 'http://wx.qlogo.cn/mmopen/ajNVdqHZLLCsWBBpicjr8ibcLSqRBibnPS0bc2Z2RNED6dC4Y4NeR2pFFtGFueLCto45yzqaxDVSpiaqHOQ8lib4liaw/0', 'odavgs_Kb2MJY6Ju61XTlViC2n1M', '1', '72', 1, '2016-05-17 14:23:54'),
(87, '13910087426', '小夜猫子', 'http://wx.qlogo.cn/mmopen/umYhnlBASpyl06et73lggoHHOLazTzPXOrwJeV86ic2h3heBUtnTQhhBwGic4evhAFk8rD2pWEO62icVp8IsEbEtWY2aXAHRWQD/0', 'odavgs4sAhxVFYHt9bzuIT0Hph2U', '1', '72', 1, '2016-05-17 14:30:43'),
(88, '15901229155', '小南', 'http://wx.qlogo.cn/mmopen/ajNVdqHZLLD9ELBbcdjibJMMUwIFwibiaLb34TOBOtNS163ArEEic6427fwqhvIJdkk2kadKWibYUIED17GKJyicoFzg/0', 'odavgs1LvBg9QbXWRCLWxQbLOoN8', '0', '84', 1, '2016-05-17 14:30:58'),
(84, '13811201672', 'Amy', 'http://wx.qlogo.cn/mmopen/ajNVdqHZLLA3ZLkJR1xdBOdmkL0HhPtquZd1Q9xnibLCfM6OaghzcViaZYcpI2JLtia8xYhXcibG0MpjliaKfUXaUvg/0', 'odavgs9gTyrQXEvO2Yz8p5MGB-w0', '1', '72', 1, '2016-05-17 14:23:29'),
(83, '13810289086', '桐桐妈', 'http://wx.qlogo.cn/mmopen/mic2icHcXUtBnvg7cEjjxu6L2x3gXvqiaUdHNFZXI9VTPzdMFGEd3v0vwLBfMwNaD2j6P0TdGpoE1oK6EM1vguczNs1023aSoml/0', 'odavgs9_E5Ia4Rg5aWRaTVluyIUc', '0', '73', 1, '2016-05-17 13:58:52'),
(82, '13811422344', '潘', 'http://wx.qlogo.cn/mmopen/UKtKwnNOk7wSOibtYwfiayKzEAE8ExJlWM2NbmXia2slicFS54SZwlakMNS9SZibwialQlIjPXSTico6TUQ9nHmtxWkrDCQWVoSx25O/0', 'odavgswmGdX1saoMSm4J5UodbVE0', '0', '73', 1, '2016-05-17 13:17:15'),
(81, '15040224240', '王松', 'http://wx.qlogo.cn/mmopen/GCbNicubhljSBal0w0J6uDVu4fjtVEbicWMF8a2XXgbcleCb8G0LicCRAl5Sh0NEBqMkibMsJWjlOu3INibIfVZA0BwicYj3kx6aPu/0', 'odavgs3VEkuIxWANXcqAZ5MOL8sI', '0', '72', 1, '2016-05-17 13:12:58'),
(80, '13761878220', '樂', 'http://wx.qlogo.cn/mmopen/PiajxSqBRaEK0oafJ1cy4HNEw8zqS5qEdam5Raq9ymeQOyKbz0YToo1wEVrr7cqJOtxBYJhgHYf11KbCEjed8gg/0', 'odavgs3m7G10-zkB8lHIiZc6spjs', '0', '73', 1, '2016-05-17 12:55:20'),
(79, '15901116610', 'Jason', 'http://wx.qlogo.cn/mmopen/GCbNicubhljSBal0w0J6uDXxsFT4M7yQ1VelwD9ywxsBibUVAsMzZkHwzs1WaRwReHwIwqdfYSHylDhIodO05UkHtbcqXOaq3ic/0', 'odavgs5oea6rJlKj6a4e1YR4SHcI', '0', '73', 1, '2016-05-17 12:52:49'),
(78, '18601362183', '麗聲', 'http://wx.qlogo.cn/mmopen/PiajxSqBRaEKUa4INcERJziaPHVAxxLbmJ278IicDYRKAbGIs6aMhslM4EawOialU5KBibdGM0YWeAyOu04R7jxwMmQ/0', 'odavgs8IYLG2r7C375bNg4a8r4Vw', '1', '73', 1, '2016-05-17 12:49:41'),
(77, '15806079696', '伪叔叔', 'http://wx.qlogo.cn/mmopen/umYhnlBASpyl06et73lggpdrGZP9I7c3ccsh8MxS0Uv6ZsD2da3NSyOWTFGicXFhjGsAMR93ebzTmRnwp39rxh8OfXoZdKvgs/0', 'odavgs1CFrX_vHqTQbI_7MqTh-Ac', '0', '73', 1, '2016-05-17 12:44:42'),
(76, '15001108600', '有人是耕子', 'http://wx.qlogo.cn/mmopen/GCbNicubhljSBal0w0J6uDWFH3rcjtK2p7oWDRSzcXzqlQpugJOBmhPK5z88dOjPL2OvqYDmHHGCqzzjMYNiae05YDgXxuiaXWU/0', 'odavgs1ZmF-409JXdonw_WAQdvO4', '1', '73', 1, '2016-05-17 12:43:06'),
(75, '13581528594', '李平 | 掌灯人移动分销平台', 'http://wx.qlogo.cn/mmopen/PiajxSqBRaEKiafZZSujFC2DSgcDcnBTjibIOqDuB1XQqQWsdjhUY3Hy420QPBRmdxcjL07bUibUylSD1OiaDaCkyZg/0', 'odavgs1fSiKFilSXidwazs7-Y5lA', '0', '73', 1, '2016-05-17 12:42:34'),
(72, '15210901186', '小黎', 'http://wx.qlogo.cn/mmopen/umYhnlBASpyl06et73lggrBia3Xt59k7AicqQUiaRpp98QCww6Pibr73sBTLChKs05iabuHxY3XVwaiazZyjbtNhQvREBo4ZYlE7Jx/0', 'odavgs_UWkBx8SOpLqiQ1dv9EnlU', '1', '0', 1, '2016-05-17 12:04:28'),
(73, '18611492382', '天赋异禀的暖壶', 'http://wx.qlogo.cn/mmopen/PiajxSqBRaELklFxXicnThm5xl0XkeGcWyiamW9b62W5m7btxWlnN4dRsr53OyadHIODYzFuuwFAsBLveeStojd0Q/0', 'odavgs1fKj2mNN1q3ISv82GWsgyg', '1', '68', 1, '2016-05-17 12:40:01'),
(74, '18633087635', '闪闪', 'http://wx.qlogo.cn/mmopen/kiaXicXJs2M4d2NYyv2Fw7qqE7ODyvTFOI85GPPb7f8u2Ytib4dxwnMu9u2orVESH82qOILBqrBZYsHEXjtTBPTlyiaQtz6eEemd/0', 'odavgs16D8c4ZjHdOY0OrF2n7v5o', '0', '73', 1, '2016-05-17 12:42:05'),
(71, '18511286258', '亮仔', 'http://wx.qlogo.cn/mmopen/UKtKwnNOk7wSOibtYwfiayKz25E6wcKMJUDcvfaKrfvFsT0dD2f5CDgypy1gcBvU2jXx6UViabK3pFelGN3kx9gpJibczNaZW6ic3/0', 'odavgs8b4E9IpPtbB4Uw2YWO2qkI', '0', '0', 1, '2016-05-17 11:58:31'),
(70, '13488750988', '郑昊天', 'http://wx.qlogo.cn/mmopen/PiajxSqBRaELaPq34X7ZEz2qgiaL8EGFUlHKZs5xRNG0nWmKMbQ47aKgRLhCI70zce0Oiaq1jk4xpibMibhl8qKpcQQ/0', 'odavgsw3w1JT281NCX4J0BYJlUxo', '0', '67', 1, '2016-05-17 11:49:16'),
(69, '15210520602', '拙依米奇', 'http://wx.qlogo.cn/mmopen/kiaXicXJs2M4dibo6Nhmh6ouTLqNBl8ko07pI7PKgibsdUfqnzh31nRtIHqibAKXiagmUrTMkibOy6lXeTMBgTYstJibpw/0', 'odavgszKWzQ3iKi99VpGpv9jkNSA', '0', '67', 1, '2016-05-17 11:31:56'),
(68, '18618269864', '黄菱芡linn', 'http://wx.qlogo.cn/mmopen/ajNVdqHZLLCBVZotgY5WvCBiazY5SUvdypRrxZezjzx2bKupyx845LSlIrxHicYJ8AgpdGKsGicr9a2N9QhPR0HZQ/0', 'odavgs-MUlmadP2EO7ntxMQP-PrE', '1', '67', 1, '2016-05-17 11:24:31'),
(67, '17701057914', '再不努力就嗝屁的康康', 'http://wx.qlogo.cn/mmopen/mic2icHcXUtBnvg7cEjjxu6AlB1IgmsciaQJXwS9WHU19B87Ric5PSicdrYJlE3pxMBhZaCId02O9EceMVTlNoxEibqNic1OV1oicFVj/0', 'odavgsxDJUFcZhC6exMxm7BtHwwY', '1', '64', 1, '2016-05-17 11:23:38'),
(130, '18146529185', '李娜', 'http://wx.qlogo.cn/mmopen/GCbNicubhljSBal0w0J6uDRXzKZNqQPRR0FQqSnl7LibM9nkTHjSSePTyCb2fCKRgHXjgkHoxa0ZHTSdgQuj1eSF1tXG5f2pd3/0', 'odavgs1j8BX-H3DKiYWp-To1OAtU', '0', '0', 1, '2016-05-18 09:39:33'),
(91, '15010360168', '靳小涵和她的猫', 'http://wx.qlogo.cn/mmopen/Q3auHgzwzM4iaDP42aIUqNxELOib9N8gPOFNhmcwCic6ibdjUu8kMMic9SChBqFm8oPmfGA07kxLPNicNQdiag7YfL5jsRGAjvb1OLGXQWKYyDQUOg/0', 'odavgswSuOlE-NGkf1IhmUTxwLm4', '0', '84', 1, '2016-05-17 14:38:34'),
(92, '15901245876', '徐倩', 'http://wx.qlogo.cn/mmopen/kiaXicXJs2M4cXvJt5YKT9ofq92MgfNdk6awRZNdVLMU6ge8xyCNsDUQMMVxicXjDUCIK8bicpm8W0k2DUAVp69b0g/0', 'odavgs2RtKrnx_e_TSdnTB3tM8f8', '1', '72', 1, '2016-05-17 14:43:05'),
(93, '13718488790', '做最好的自己', 'http://wx.qlogo.cn/mmopen/UKtKwnNOk7wSOibtYwfiayKzlO8xlf2icsbtfhOMxHNdzMeLsr3SKFkHqAA7cp1km3yabGEZIX9iacaic7TL9HYdE54BTRyfeTMrL/0', 'odavgs7pUmwAuVm0OfvqOAa3tEnk', '0', '86', 1, '2016-05-17 14:47:28'),
(94, '13910304292', '武动天涯', 'http://wx.qlogo.cn/mmopen/UKtKwnNOk7wSOibtYwfiayKzThbALAdachNAaxhvJOUdZ7e3nqfiakcucrTpohqlkQvV27Etg4aGo1pvaVJkAvNMmhv0c21ALicf/0', 'odavgs-hlzZFPi2Ao7I_BBvVXBnk', '1', '86', 1, '2016-05-17 14:48:09'),
(95, '18201107703', '莲莲', 'http://wx.qlogo.cn/mmopen/kiaXicXJs2M4d2NYyv2Fw7qvxapTUFOEMoZUibeow5vr9SILx7ufyWCHAiaGOXL2N7aQ9GzS0gOpuLoND2uXCFAGY5SZyU3Awyc2/0', 'odavgs39tsgPGBRhEt7-Gum2CCY8', '1', '72', 1, '2016-05-17 14:48:44'),
(96, '15311737797', '姚卫', 'http://wx.qlogo.cn/mmopen/ajNVdqHZLLAygMHJu93t0A2DRfnd4AcEH9oUnElibk9P7UguicSCvJOk3vV5rynJeXiaIIia0Gf7qkcwChe9ARUXlA/0', 'odavgsyoJy6yKb4MxthgiksJFbmk', '0', '85', 1, '2016-05-17 14:49:00'),
(97, '13683217945', '强哥', 'http://wx.qlogo.cn/mmopen/mic2icHcXUtBn1JOdIAHQXH8LHDpQksv2iaM47m4D7CTBd9Fs4vCUKzhVFHIIRISM3Egwov2OXa0iahFGqqaypWIlLNSfwbaUZsC/0', 'odavgs7sjilicL9RdubGoVEWMsho', '0', '92', 1, '2016-05-17 14:59:32'),
(98, '13811439788', 'springchen3', 'http://wx.qlogo.cn/mmopen/kiaXicXJs2M4fLeAKIKaveWSH6nhdUdoiaaDticgCN9eVSXe2Lwg5TdtcpqhHSBwg5382F6LrvNBKOhGeymR2Aexhw/0', 'odavgs0P6m7nCsJeRn5XTOOYU1xM', '0', '84', 1, '2016-05-17 15:12:38'),
(99, '13651334627', '闫立阳', 'http://wx.qlogo.cn/mmopen/mic2icHcXUtBnvg7cEjjxu6EjudVX3qibWTr3icD8kF4MTcxlh7fzaDrXypdEP0vy0bEJde0FYT3iasOmHOBnh2jwe39yVRC64ibJE/0', 'odavgs-t5inrdjIH7lUI7ouqgMkI', '0', '95', 1, '2016-05-17 15:15:39'),
(100, '13604099781', 'Vivian', 'http://wx.qlogo.cn/mmopen/UKtKwnNOk7wSOibtYwfiayK8PYyWLuuOCGf5icztOHWYPicy7qicfyGaDMDscb0hEuR9kTWIwSgJ5dpBj52eyxzQgzWuVTLg1OGhB/0', 'odavgsxwSfsW3_WNs5JYClg7ZXPo', '1', '72', 1, '2016-05-17 15:28:40'),
(101, '15652956544', '三阳开泰', 'http://wx.qlogo.cn/mmopen/UKtKwnNOk7w1WlnexzEkdjUF8rES0qB9ESIfCOZuGg9VVPxLhNA5WfqoIVcwAyRCiapkicvYNgwlUyRToPAxuPb8rGO5nsNSiaw/0', 'odavgsy0-5uJCPkYPV1SkHQnjvMY', '1', '100', 1, '2016-05-17 15:43:26'),
(102, '13704091616', 'PHOENIX', 'http://wx.qlogo.cn/mmopen/PiajxSqBRaEJdLBEhzgSoiahA872DWqBrty5fNTsU6BllQ7DS0Q99ZxeJKDR3kwiau042XlicEkk8WzEf77iagHjkyQ/0', 'odavgs013wLxiwt2dVXyBFmLtAe4', '0', '100', 1, '2016-05-17 15:57:18'),
(103, '13552511466', '曹继磊13552511466', 'http://wx.qlogo.cn/mmopen/ajNVdqHZLLArjAbiaT3DqAcFCx5G4icvwUYwyDHGlcUDCs1jiayqlgByPyO0nDry9JqBJ4yNqib9THzWAVqK4cRjgA/0', 'odavgs5o1pWemUeNw0PqSh7RaT6w', '1', '72', 1, '2016-05-17 16:41:36'),
(104, '18612230309', '', 'http://wx.qlogo.cn/mmopen/GCbNicubhljSBal0w0J6uDbEgL6ibVb7pWtHN9vjfZCkGT7PibmsW6j9cSicu6tYUfZEp5xO5XwpWTCrJj6LDYHWWXDhMjic3VsCy/0', 'odavgsyOX7hZC0STSVDj95omqhpM', '1', '72', 1, '2016-05-17 16:54:04'),
(105, '15901546546', '阳光明媚', 'http://wx.qlogo.cn/mmopen/mic2icHcXUtBnvg7cEjjxu6K8xy3AY379AgiapfX3iasQEUwqZX8YPhAv7Lxrey9pRBicC7ln6rqauuGQ4L45eAVPiaicY9ibGVbSTxx/0', 'odavgsyvytzzBLOvzMQXyGPo5YSk', '1', '72', 1, '2016-05-17 17:01:32'),
(106, '13701009123', '肖力', 'http://wx.qlogo.cn/mmopen/ajNVdqHZLLBic4aJrp9mEiczZILRZDkBS85gUHk5P5Mia5asAkFHMGyicV4BfefTAmuOYlP6YQL9gvfcZ61j7GpETw/0', 'odavgsyPo90441I97xDUSpaMuFvQ', '0', '104', 1, '2016-05-17 17:03:06'),
(107, '13811614765', 'cagia', 'http://wx.qlogo.cn/mmopen/GCbNicubhljSBal0w0J6uDSkxV4tNbeeuxeRsvqqicSpdDUosEKauJ4gYFsAIsbYRy8RjLYtg0QkMsA0iahkYblicRfGheeslXDY/0', 'odavgs5wXx-zhhC0TUXi_aYLEP5k', '0', '73', 1, '2016-05-17 17:07:48'),
(108, '15010453075', 'levin', 'http://wx.qlogo.cn/mmopen/UKtKwnNOk7wSOibtYwfiayKxwMehJwOS3aohGr2o2FA2w2gxd84oV05JcrLdHUBespyHqribjjY2NYTic52DuQ3iag9BfGBsw2Tkh/0', 'odavgs235_wCFptS1eCKDQLMvzTk', '1', '72', 1, '2016-05-17 17:18:21'),
(109, '13051912215', '奥林庄园 会议 拓展~齐', 'http://wx.qlogo.cn/mmopen/mic2icHcXUtBlhf8nA9OSg1H2BnUs7MpAtpFxNJxxO8lkF1oBFakrNZ6Ojs5vc7iaBIsODqjv4zTEEPS1Wd8ayAziaFZ0AvOEMt3/0', 'odavgs-0seV19bylD0f0-yD_4oJ4', '0', '72', 1, '2016-05-17 17:35:13'),
(110, '13661282555', '敏', 'http://wx.qlogo.cn/mmopen/kiaXicXJs2M4ey5mS8tIibiaEv6vyS8G3mOK3aBPbmdc1YL2HBicIOKUKAhdB2WrwFggZG4GEUPvyAL3lpibibZu4RBoQ/0', 'odavgs-6W9i4mMYWtXtYD9Cl3g_k', '0', '104', 1, '2016-05-17 17:41:12'),
(111, '18612866963', '北京圣道  哮团队 吴肇锋', 'http://wx.qlogo.cn/mmopen/kiaXicXJs2M4d2NYyv2Fw7qssiaERVOD834qaiaHccoE2Hw0kV63nFNYOd7pib7KNZDL8GM1t3gCC9tic4xHvGXkBYNLiaZHjoQiavOu/0', 'odavgszJ8b2sLtfnpjW0ROJinle4', '1', '72', 1, '2016-05-17 18:18:25'),
(112, '13520032740', '牛小牛 ', 'http://wx.qlogo.cn/mmopen/kiaXicXJs2M4d2NYyv2Fw7qsI14q5ImRF29yznicH49sMaoJ8n4le29fVZPiaxAGJezdb6e8wYT3KV80TYxVJ5fcMwKTVo7ia3FAW/0', 'odavgs5_9eVqsPmDa8GlcQM57bPw', '0', '86', 1, '2016-05-17 18:33:14'),
(113, '18800116774', '绀墨', 'http://wx.qlogo.cn/mmopen/mic2icHcXUtBkTT1rWKk57AXMPVT5yGA80GD36tWzenlRic6XyWxT8TjadFIrUPe9lWaIJ1LEEKxPNbAbG0I0QtgrXQt6KOTibGN/0', 'odavgs-2uoK_2P7eULsKexwkGaGw', '1', '72', 1, '2016-05-17 18:36:51'),
(114, '18600869021', 'Andy 宋', 'http://wx.qlogo.cn/mmopen/kiaXicXJs2M4d2NYyv2Fw7quKIcoj1aJwMsbJQrNUsYzvtFSXEeIAKKkU8z8G0ycBZo1uYH4iclmdCDzb1lWMjQngZuOTt11p4e/0', 'odavgszvFkta_xPxZFTXZAjowfnw', '0', '111', 1, '2016-05-17 18:44:41'),
(115, '15011170125', '景', 'http://wx.qlogo.cn/mmopen/PiajxSqBRaEL7McrQyDpkoprlpicMm5dsBfHF9DcHexRm8ibnrrl1DfjYVEQX0p8IiaJ8ibiaK4H0Ghz1A5s8ibc2KAsA/0', 'odavgs8HDnvdG6kTvBOBJCpO_2-8', '0', '0', 1, '2016-05-17 18:51:55'),
(116, '15210476884', '小河流', 'http://wx.qlogo.cn/mmopen/UKtKwnNOk7yXOkxdjAlCDH06xBSgd1Q2P8bp6hetrXXXgRpMKnanbUJJXrUc1llw5TE1epyTSQoCeVePZLVskg/0', 'odavgs9n_NQ2Q_4qK-ioo7cF-nlA', '1', '72', 1, '2016-05-17 18:57:42'),
(117, '13811201671', '大老虎', 'http://wx.qlogo.cn/mmopen/UKtKwnNOk7wAA7IhianRMpdToqs51JPZmyyRW2cP7f2pzxNcedh0vduYnC5YeTxK6pqr6pj4ic0vzZuObBaSLF7Q/0', 'odavgsxtwcNppHnFUKA9zBmt1nBU', '0', '84', 1, '2016-05-17 18:59:22'),
(118, '15910421291', '▼ 熒  丶', 'http://wx.qlogo.cn/mmopen/mic2icHcXUtBnvg7cEjjxu6CuCq0FXE9ViapicUUCibVafJGu6MuYLF4nDGUc9eBEMtsyTYic3V8vkQV7RbMLASIBmEVKmIVibOXVkk/0', 'odavgszTvj8e-KcKZK3IYw5MDYBA', '1', '113', 1, '2016-05-17 19:06:45'),
(119, '13810676482', '李莉', 'http://wx.qlogo.cn/mmopen/mic2icHcXUtBnvg7cEjjxu6MmneUmrhicaia7ye2GKrCepqToWA9daguzgSzuSVj2KR6MlyGU7jVnfZzhnYGCB7SCWJhOPickxhRh/0', 'odavgszCOLCXvvfml0sYe107IwOQ', '1', '72', 1, '2016-05-17 19:36:39'),
(120, '13301071209', '雪儿', 'http://wx.qlogo.cn/mmopen/mic2icHcXUtBnvg7cEjjxu6DpD8F0cZeAcmwRaMiafcCpoFr4HywUuF9oUwDA1wTJYzAMTXckgEmvsJzCW5J3ntVAzmickmxpRfZ/0', 'odavgsyFKzCUWV7zNNbS0CxFpOeA', '0', '119', 1, '2016-05-17 19:51:42'),
(121, '13621392440', '蓝色', 'http://wx.qlogo.cn/mmopen/umYhnlBASpyl06et73lggrbt9x6ZPrMoBF1TELHgEEtNftJGBJWibk0Sze3w5gTuoantb1Zk4pBSbDAndsmFOqMBngr5pps2C/0', 'odavgs8S0pPz_eRGaT_n6LAap96o', '0', '119', 1, '2016-05-17 20:03:35'),
(122, '15836383166', '夜空中最亮的星', 'http://wx.qlogo.cn/mmopen/PiajxSqBRaEISiaGzCMSChy6fnrQcgxhwnfFsvveRjQy8rVcM4gbWicMicP6eM7kQxmSt3b7ax43I2rGpCGEiaHNkHg/0', 'odavgs24zd6PWL6R5XMUvfdYAVxs', '0', '113', 1, '2016-05-17 20:19:48'),
(123, '13581833779', 'Wendy Wong', 'http://wx.qlogo.cn/mmopen/umYhnlBASpyl06et73lggh583IR9xHQfz3RUicNvBv4cNmt691zIQET3YEgIW2m3j55fxHNWwY8w1x67CAEJiceiaN5e9z9xs2M/0', 'odavgs0i49yxiT8CcIls1AcKWsGo', '1', '72', 1, '2016-05-17 20:33:46'),
(124, '13426249192', '贪睡的猫', 'http://wx.qlogo.cn/mmopen/PiajxSqBRaELGlxbHjmgAm3QplaialA4riaibDejrRSAwLf4WYZCfC0srVq9RtIktViaLrAufa55DV5dmkzbWhfvBIw/0', 'odavgs9JbETP3SXUJRwGotMgP5IE', '0', '123', 1, '2016-05-17 20:47:16'),
(125, '13601008531', '我爱。。。。。。', 'http://wx.qlogo.cn/mmopen/mic2icHcXUtBnvg7cEjjxu6FSmyuKUFvQdpFkV8yhXJXSRMLHTCpE6PzNQRibicTvDLq90X0ZZUeYy5FZrtviayCGrPzEaRU3icNM2/0', 'odavgs89iyZcDsGJ69C9C44K5OXE', '0', '111', 1, '2016-05-17 20:48:34'),
(126, '15645411106', '期待爱上等待', 'http://wx.qlogo.cn/mmopen/GCbNicubhljSBal0w0J6uDSsM4HZng6icaewCMD8SQ9eKCFDKia6Oeyicib94vic8icD4Ha09WZ6xg7vjlEuGGNmQGqTbkKjl6Lf2TY/0', 'odavgs5gN5eZ74M3k-wiXXdubzxY', '0', '100', 1, '2016-05-17 21:17:11'),
(127, '15201470126', '包欣蕊', 'http://wx.qlogo.cn/mmopen/GCbNicubhljQicCppHVyuMGicEicgdiaqvZQpb4rtT2Aicw3OtACcc8wNtiaH7u8MbnO1Aicozw5uaAqORX6RamRgzq5VPaptowRYLkf/0', 'odavgs4UBcBBXz-2JkdTvX58AE2o', '0', '123', 1, '2016-05-17 21:37:29'),
(128, '18193708791', '恩典', 'http://wx.qlogo.cn/mmopen/kiaXicXJs2M4cGzqojAH0OWOuq7h129y3YWhpn96BdKHusF5GZcekJiaHKQslhGwJa0L1MyT9fJL0C5JLKJl6LkzuHZ7eLXUPibY/0', 'odavgszSZ1VUtV8HOg-lIUCd-igc', '0', '73', 1, '2016-05-17 23:01:23'),
(129, '13581951232', '', 'http://wx.qlogo.cn/mmopen/kiaXicXJs2M4d2NYyv2Fw7qp80qzHib766hwd1x7jH7UPVAM7rWhIYm4EN7JCEcN3HFSrGJ8GzVDKGWqpvIlYDIs6Nu54PgGgce/0', 'odavgswwAqVFyTLe_wbvL0i9pgww', '0', '73', 1, '2016-05-17 23:20:43'),
(131, '13910837033', '周游', 'http://wx.qlogo.cn/mmopen/ajNVdqHZLLAwrceeclmPJnuhH3UDP8TWh6hWiaHEy7w4az7eqIeH6GvqiaJKYicsKfe8HOXgQSYCtIQwOUx4icO7zQ/0', 'odavgs_3YnBEoI2zbYKupfiCrf5A', '0', '73', 1, '2016-05-18 10:15:40'),
(132, '13353513322', '妙笔菡塘', 'http://wx.qlogo.cn/mmopen/GCbNicubhljRHhtNLhrEa1kzOXjQt21kKBr1QcSe6SzNDwaLegU9vehFcr3b3UvDUjdkHJk76DdkfmTLgUm6qEDXbd2z6ZaZY/0', 'odavgsy_EZ2JC2ckgj3S69fBatDg', '1', '68', 1, '2016-05-18 10:17:19'),
(133, '18612701615', 'Lucifer', 'http://wx.qlogo.cn/mmopen/UKtKwnNOk7wSOibtYwfiayK5IZOYbzicv4wY4PnyXNs9m9f96qT10A4s39SHBjaGibwJVocayiaicLHmIpDZsJibic3FNCdUeNKGKKPa/0', 'odavgs-sOLFXFgn6HbsuHxdKEKDU', '1', '48', 1, '2016-05-18 10:48:29'),
(134, '18519518677', 'ˋЁyesゝ', 'http://wx.qlogo.cn/mmopen/mic2icHcXUtBnvg7cEjjxu6EbjAnaSf7JkBturdb2Z5uyQjcSfDswcqL87sz5dVZYgU5KXuCeGIABB263E8aBPI3Rx8kHXCbTJ/0', 'odavgszCTGZzSwI1zqZKxf2MFWkA', '0', '47', 1, '2016-05-18 10:53:24'),
(135, '15801617854', '', 'http://wx.qlogo.cn/mmopen/PiajxSqBRaEKp6ORyJcVp22mHsbGWUBfkwPf4PwNvwtXojKjdYVSZxNaxYS8CtBicf78cicG2VX6LmM0OzDsIa45w/0', 'odavgs0BUd7B5e7rwutlOzQ16Ez0', '1', '72', 1, '2016-05-18 12:18:48'),
(136, '13651399827', '⭐ Queena ✨', 'http://wx.qlogo.cn/mmopen/mic2icHcXUtBnvg7cEjjxu6FUe7C5FaeR9KeooicgZzoO4oncEicVUHiaKicBKMM1GyA4V6yBbTIibSXkOgVlHPmmQnYPRlVh61ZlOh/0', 'odavgs53IMXg0Hmy_fHGPSZpT1mg', '1', '72', 1, '2016-05-18 12:27:56'),
(137, '15901040050', '小贝勒', 'http://wx.qlogo.cn/mmopen/ajNVdqHZLLBWBQATbL61Jd3CT7KJq6iaKLbgsMgHtQxcJv2gRnk3AOgB7NG2Q7gHXvFiasZ6mGxPBzGJp7iaAIhGg/0', 'odavgs7MxGLQVfdXBRR07xOjAANY', '0', '72', 1, '2016-05-18 12:40:45'),
(138, '18235137841', '心欢18235137841', 'http://wx.qlogo.cn/mmopen/ajNVdqHZLLDlGN4BiatMmfv2qVR3ibFGMNDqJ0brqrjutsmP8g2RJsrXJWS96t4z1fsQCgiafibrYLgTn0zYicIbr9Q/0', 'odavgs8HimVDPIZJrcwy8k29j6Kg', '0', '132', 1, '2016-05-18 12:59:26'),
(139, '15649617474', '真法', '', 'odavgsy7ZC7O6gk5X1Nlmmo20808', '0', '0', 1, '2016-05-18 15:32:41'),
(140, '18610810152', '孙岩', 'http://wx.qlogo.cn/mmopen/Q3auHgzwzM4iaDP42aIUqNxELOib9N8gPOVPVS6icpdrtfjBsOO1SqULp9iaRYkBEdrqkGZPY68HotCTwiadGuhJGHjgxQ5ialotRCCxnUT6p65Ok/0', 'odavgs7W0owc2uk4AyEDAwP3H6Ys', '1', '72', 1, '2016-05-18 17:48:50'),
(141, '13426151184', '杨瑶', 'http://wx.qlogo.cn/mmopen/GCbNicubhljSBal0w0J6uDdmZ0eiciaXOZx7pLKywbfFRz6yt1icGYLR25KSfKByb8ibibvicgshDYkeLG0ghorwSdLJz4eGAU8ylHH/0', 'odavgsx5jdcvzbMjRg1jSJe0roms', '0', '73', 1, '2016-05-18 18:18:11'),
(142, '17731835702', '霞女', 'http://wx.qlogo.cn/mmopen/GCbNicubhljSBal0w0J6uDYvLJHLBiaticl4bxshCt2Scb1WScF1LeKdPDORaShTl6Wo09u3XEAE1TP39ebz8l6dycx9QANrVVK/0', 'odavgs1Ys3oo-ECCKYesK_UNXSV4', '1', '72', 1, '2016-05-19 11:28:35'),
(143, '13810135386', 'Stephanie', 'http://wx.qlogo.cn/mmopen/Q3auHgzwzM4jJgjKBjDbKvotA9NwxUTjMog5eocp7bUPjoFMnfKJF5dZDqaVEfQMVsJv0yPNUwZFFnUYnMf1zQ/0', 'odavgs74J--RXjrEBr0tdgYUNr7Y', '1', '72', 1, '2016-05-19 11:29:44'),
(144, '15810660763', '¹October', 'http://wx.qlogo.cn/mmopen/Q3auHgzwzM4t4g8HYlZGw89haN8lomvrcu2ibB7TSwicNS0tKR8jSichTqzkcbEjMntwhiaFLvIkYLeofH7JfhRYtA/0', 'odavgs5LBSYgJTbJ4zeCtun0BwsU', '1', '72', 1, '2016-05-19 11:30:58'),
(145, '18774085281', '陈锐', 'http://wx.qlogo.cn/mmopen/UKtKwnNOk7wOzP25ibxkYUA3lDMYjflibn9pjd0IibyVyQ5XDT6ibKLxSibiaHib3EGlygNGwAhILqlrnUEDe7puquIjvEeuyEmKKrG/0', 'odavgs43FHyZcKxH6mwvZFVm8EvU', '0', '72', 1, '2016-05-19 11:33:00'),
(146, '13810184035', '❤️王夫人❤️', 'http://wx.qlogo.cn/mmopen/mic2icHcXUtBnvg7cEjjxu6NEiaE3Wtru9BfxJFBXX8pyf5w2tbzHdIjysnjyCoDtqP0dA65J5OcT055fN8DMYN6XR7QtJmcMyw/0', 'odavgsxutAL59V7DbIaPq4dQgbns', '0', '144', 1, '2016-05-19 11:43:39'),
(147, '18612262565', '宝贝家', 'http://wx.qlogo.cn/mmopen/Q3auHgzwzM7ianMbLLGwLxTaNZsib0zAZXl0PEReicyDSIIHAXP3XI9mFibtlS3pA1GlL50vKmqz2WpR9ib2t2pbv7alevSOnvxjzdaMtdDD5ibxk/0', 'odavgs7lzmp0o8u_l8M5X-S2DjyQ', '0', '72', 1, '2016-05-19 11:57:21'),
(148, '18510882762', '踏雪无痕', 'http://wx.qlogo.cn/mmopen/UKtKwnNOk7wSOibtYwfiayK88qp2UQ0RvaD4wn84RcU8XgVHHVLN3eGlQQgCBkbMD0ZDeiciazUKEZNRt5jIdIDTMldic93kE0Ok9/0', 'odavgs1xzyhwDvbWKmyuPou1p3Hg', '1', '72', 1, '2016-05-19 12:13:49'),
(149, '13717877297', '国功正道-吴馆长', 'http://wx.qlogo.cn/mmopen/mic2icHcXUtBnvg7cEjjxu6O1QWy3Hxbn6o4icchEy4I9gt8qWOGHibLXViadk1LriamY8EfDrYuhYVZ4f4auMI8fIOnKNeDd3JEX5/0', 'odavgs6Bki71ayZedKp8bq713vHg', '0', '111', 1, '2016-05-19 13:14:56'),
(150, '18613811777', '高兴龙、', 'http://wx.qlogo.cn/mmopen/ajNVdqHZLLAITHLpwfk0WCbap5cSicF2lgXe6aIBOfJPNsnEbT6tu7qOmXicxAZOakIyQNLn4NxObP2SmrrRb95g/0', 'odavgsw1KEl-2RMcE1FBVJzYV3bA', '0', '72', 1, '2016-05-19 14:29:57'),
(151, '13072221372', '曹泽润', 'http://wx.qlogo.cn/mmopen/kiaXicXJs2M4d2NYyv2Fw7qiaFNJcsOrcq4CXolxSPDWjibnyMLYoJq5jxpNxM1A1ics5qITDKJ7s3wGeJmN3ssD4ia4OZMXs2MHN9/0', 'odavgs9EH9H6ptmkOUo_uQ6hdhiY', '0', '72', 1, '2016-05-19 15:22:36'),
(152, '15620237717', '王 嘉', 'http://wx.qlogo.cn/mmopen/Q3auHgzwzM4r3FcdcmcONUfuELBmN2wgVqtp0W4m0Wibf23yAS0lY76pxGwza9ghEibDrtIlQrTvWxrtf0hTNjO2GPCKXMk4BiawskFafo1CAY/0', 'odavgs9mCaUkUPuX0dFEOctnCFP4', '1', '72', 1, '2016-05-19 15:32:38'),
(153, '18600586460', '范范', 'http://wx.qlogo.cn/mmopen/kiaXicXJs2M4d2NYyv2Fw7qgwKVCyiccUrknKibOFRflWQyUI5lLLamatqmVflGmA7c9yHHgj7sibdtB3uVmBhV6peaxvhY99hzqs/0', 'odavgswFple87hpTqKV-RkHYCr7w', '0', '72', 1, '2016-05-19 16:32:59'),
(154, '15110018175', '†SUMMER†', 'http://wx.qlogo.cn/mmopen/ajNVdqHZLLC4WoQkRZ28KD0ASNT8DicS28ESQo8xhmBLJYWsk6KIQuqVB8uyHPyl4icKV6Z1yXjc0FgAeD3vwfDA/0', 'odavgs7sunnX7ymLqKYns8Fm19t8', '0', '144', 1, '2016-05-19 17:37:24'),
(155, '18846656332', '小阿飞', 'http://wx.qlogo.cn/mmopen/mic2icHcXUtBnvg7cEjjxu6KcdsJibZcKgibsdJF04oyoOrLmQiabjicVzGBdJ02MuwmvZeeicounW5ytQ7fziclDSOicJVIRgs7jG0Bh/0', 'odavgs20wzR2UzAw5ipQXASEzPSs', '0', '118', 1, '2016-05-19 19:09:39'),
(156, '13810260291', '让爱颗粒归仓（张洋）', 'http://wx.qlogo.cn/mmopen/ajNVdqHZLLBWKiaAeaYLgUoKaMrW5icXiczqzdosKHkxNlSPHd758Y4liaCz3EWmS9wQtxqYXOPw45L085f6EaevNw/0', 'odavgszZn4xws_pMvo0OY6QF5JCQ', '1', '72', 1, '2016-05-19 21:07:44'),
(157, '15810907379', '蜗居的淘淘', 'http://wx.qlogo.cn/mmopen/GCbNicubhljSBal0w0J6uDYXzw7saHraGEZibncuE6SvyAPiauXWGFBlZ87EFUABDQKhFBsShiakPdETiaepYerwebgnszJSCkpkQ/0', 'odavgsySF4MwVzTPbg4HZCePANyg', '1', '72', 1, '2016-05-19 21:36:06'),
(158, '18701564950', '✎༒ཻ✿江南烟雨࿐ོེ₂₀₁₆ུ', 'http://wx.qlogo.cn/mmopen/mic2icHcXUtBnvg7cEjjxu6E1a083MGw2XJgeicPQG5jJHK0E8Z3OibbQWoRYKxIGEATLZG4S3oT6laTGOCiaY07ibpBSYicUgmiaFJV/0', 'odavgs_zVxupZFhyEAhlQWXvghYU', '1', '72', 1, '2016-05-19 21:45:59'),
(159, '18001150801', '崔赢素', 'http://wx.qlogo.cn/mmopen/Q3auHgzwzM6qNYJdiaicZVricAFjSnWnuLoIDPs1iaiaPk8wzPU4RD8T75tAcicHhHaiagWiaGPARibjE9dHPqVgIiagqUuQ/0', 'odavgsy6_WTqelzM-7smp9AQJil8', '0', '0', 1, '2016-05-20 05:27:57'),
(160, '13521884307', '郁香忍冬', 'http://wx.qlogo.cn/mmopen/ajNVdqHZLLD10T9s19SFBpsiccMhmhHEFRoB5ZJOUTEmuLuAWZsqpib5zN1ZpCZOKcKEIRJM2DrWPMNS0GvEMKvg/0', 'odavgs26_8WEkb4Y5vmLetIywfnc', '0', '0', 1, '2016-05-20 09:34:14'),
(161, '18641930705', '媛圈圈', 'http://wx.qlogo.cn/mmopen/umYhnlBASpyl06et73lggiaib4YMhyuFOW7sf06kdMnqYyoc1ncRiaQLEdA6iaKtl5VoPhWWEvLabl1gNjp5esGqn4RPvceKCF1k/0', 'odavgs1Og1wtX0By3yB5ljUUVEz8', '1', '72', 1, '2016-05-20 10:52:40'),
(162, '13031088565', '如此简单', 'http://wx.qlogo.cn/mmopen/mic2icHcXUtBnvg7cEjjxu6O0d1icoGs9wsleHvicibSvPdh5y2OKG2hS6ic3tnlEMXB39m0VjgSYD5hswYzGAiabtmibiaYUjCK44WFic/0', 'odavgs_Prs820p7U5Bnh5o1EdSyg', '0', '69', 1, '2016-05-20 11:07:25'),
(163, '13269710778', 'only one', 'http://wx.qlogo.cn/mmopen/UKtKwnNOk7wSOibtYwfiayK81mZXHX2VpVdatx7Zxhzwemo3RaNZllN6Wiaic1voLELT3yKicldYt1BkwPwvENjCuiaUAGtPDaDf85/0', 'odavgs_MBmgaEsnQsgT9K_AcABYg', '0', '72', 1, '2016-05-20 11:11:24'),
(164, '18610441184', '友邦保险(AIA)   朱佳', 'http://wx.qlogo.cn/mmopen/mic2icHcXUtBnvg7cEjjxu6IJnDdcUVPxgsSlnhhRXXz6s6YHrwZxKMs90rRgbLQAHniaILryB27nrVQu9RBwn5frt3icpgMicyhF/0', 'odavgs5cuv_SG7PXGoxMWEINMtRU', '0', '72', 1, '2016-05-20 11:12:55'),
(165, '18236839096', 'A【艺云书法】王崇慧', 'http://wx.qlogo.cn/mmopen/UKtKwnNOk7yuicrsz38JsnVUiawektHOJ1TNot7bNqTNv2ueTujRkmxIDnNf78rNlrJFcjrbbZMVtpR3yjzZdRyfsJoZicZBzDF/0', 'odavgswGT-bXthRTudcUnbaU79j4', '0', '72', 1, '2016-05-20 11:13:46'),
(166, '18611893177', '红豆爸', 'http://wx.qlogo.cn/mmopen/ajNVdqHZLLApBaBN1SyEg8V3MFssOwNmwvBibRCKNyeqke0o2S9JD7WZvf30wVevbkWfJbcNjz5SqUgibwDtUUgw/0', 'odavgs-l3LHHdDFDpCqrjVv4AWIc', '0', '69', 1, '2016-05-20 11:21:55'),
(167, '18513299492', '日光倾城    万物生长', 'http://wx.qlogo.cn/mmopen/UKtKwnNOk7wSOibtYwfiayK1RJrQL5iclx1iaUXpFbMzXtTss1YNx6uvqAenqeAy68LLiaknqyhp6mpzf0Hkic23sqh7FqctML8Rqv/0', 'odavgs85jUNqmzoxyJYl4mQnAn-0', '1', '72', 1, '2016-05-20 11:46:45'),
(168, '18901352434', '于军   18901352434', 'http://wx.qlogo.cn/mmopen/umYhnlBASpyl06et73lgggK9kkiaXj7SpEsKeNMX98bR0fEicITDx7ibU6hic3Zib6PtqEqbqQeu3VyBTnxuTBhnX8ynwcNaAIt8s/0', 'odavgs-_SWBYIllLYPNm41HFsJl0', '0', '72', 1, '2016-05-20 13:54:49'),
(169, '13641060641', 'lff', 'http://wx.qlogo.cn/mmopen/UKtKwnNOk7wSOibtYwfiayK3k3HHe7ErLEEPqE2Sf98UkKN217jz6sWZT5zib85bmlHmVZwfbrb5YiaATtZ9Bx4f5YCswm6CBnT1/0', 'odavgs3e-XHDjFUOj4CmYFkyGZdo', '0', '0', 1, '2016-05-20 14:03:54'),
(170, '18600667777', '乌漆吗黑', 'http://wx.qlogo.cn/mmopen/kiaXicXJs2M4ebmXVGN2Gs8icDOpty3OyMoN4loInm9DBCoatatr6ETwdp7Hb3uWA7SWd2W18F9h8v36NC2jRUEaA/0', 'odavgs6DrnxgfZgtbW38kLc1z2vw', '0', '0', 1, '2016-05-20 14:16:13'),
(171, '13911229655', '中逸。', 'http://wx.qlogo.cn/mmopen/PiajxSqBRaELqaYt2DiaEFoicqcMyxZiaPich4mJEnYAWe3faQ4iaicHEUnReU1Riaib7J8S14GXfAGkgDAicahtjic6HChOQ/0', 'odavgs-g1RYdR1QBf-vuwKVGu49E', '1', '72', 1, '2016-05-20 15:03:12'),
(172, '15210421881', '李阳', 'http://wx.qlogo.cn/mmopen/Q3auHgzwzM5j9pk7dM7z2uDTSSsUFonVf6GvibzYQJ30wib5wC43fiaicywKa2CZXas2bvxzqiblz6J1bwqS1gnRVdA/0', 'odavgs56BwK6H00TQpiCz4oN0FJY', '0', '171', 1, '2016-05-20 15:11:10'),
(173, '13811804851', '晶晶', 'http://wx.qlogo.cn/mmopen/GCbNicubhljSBal0w0J6uDfG3eLESWKykU4Sm6poMHaiaezjia2mUQfYXYNr2NW2xSTgk73W5dJ9mpicmgqGQb3JczKpcmNbBFnX/0', 'odavgs_6lMEVhD1t1doH5CkuoDbY', '1', '72', 1, '2016-05-20 15:40:41'),
(174, '15810857851', '☆Crystal Baby☆', 'http://wx.qlogo.cn/mmopen/umYhnlBASpyl06et73lggpCClNf4xNqXtqiaf6UpicHRtIgIpQoicuf3qq1UmviaV8sicmzNPUeibMAU7G9YuRRewicluDuGmdnUJpj/0', 'odavgs-GGCCuiKTT2D18M4L4GyLs', '1', '72', 1, '2016-05-20 17:13:27');

-- --------------------------------------------------------

--
-- 表的结构 `yes_bespoke`
--

CREATE TABLE IF NOT EXISTS `yes_bespoke` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `class_id` int(11) DEFAULT NULL COMMENT '排课id',
  `project_id` int(11) DEFAULT NULL COMMENT '课程id',
  `order_id` int(11) DEFAULT NULL COMMENT '订单id',
  `app_id` int(11) DEFAULT NULL COMMENT '用户id',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '修改时间',
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='预约表' AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `yes_bespoke`
--

INSERT INTO `yes_bespoke` (`id`, `class_id`, `project_id`, `order_id`, `app_id`, `create_time`, `update_time`) VALUES
(2, 3, 1, 306, 134, '2016-05-18 17:52:03', '2016-05-20 14:33:39'),
(5, 5, 1, 309, 67, '2016-05-19 11:33:09', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `yes_class`
--

CREATE TABLE IF NOT EXISTS `yes_class` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `school_id` int(11) DEFAULT NULL COMMENT '学校id',
  `project_id` int(11) DEFAULT NULL COMMENT '课程id',
  `number` int(11) DEFAULT NULL COMMENT '限制人数',
  `times` date DEFAULT NULL COMMENT '年月日',
  `timeslot` varchar(50) DEFAULT NULL COMMENT '时间段',
  `start_timeslot` varchar(50) DEFAULT NULL,
  `end_timeslot` varchar(50) DEFAULT NULL,
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='排课表' AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `yes_class`
--

INSERT INTO `yes_class` (`id`, `school_id`, `project_id`, `number`, `times`, `timeslot`, `start_timeslot`, `end_timeslot`, `update_time`, `create_time`) VALUES
(6, 5, 1, 2, '2016-05-18', '13:00-14:30', '2016-05-18 13:00', '2016-05-18 14:30', NULL, '2016-05-19 00:00:00'),
(5, 1, 1, 2, '2016-05-21', '13:00-14:30', '2016-05-21 13:00', '2016-05-21 14:30', NULL, '2016-05-19 00:00:00'),
(3, 2, 1, 2, '2016-05-23', '13:00-14:30', '2016-05-23 13:00', '2016-05-23 14:30', NULL, '2016-05-18 00:00:00'),
(7, 7, 1, 2, '2016-05-20', '11:30-13:00', '2016-05-20 11:30', '2016-05-20 13:00', NULL, '2016-05-19 00:00:00'),
(8, 3, 1, 3, '2016-05-20', '13:00-14:30', '2016-05-20 13:00', '2016-05-20 14:30', NULL, '2016-05-19 00:00:00'),
(9, 9, 1, 2, '2016-05-21', '11:30-13:00', '2016-05-21 11:30', '2016-05-21 13:00', NULL, '2016-05-19 00:00:00'),
(10, 10, 1, 4, '2016-05-22', '14:30-16:00', '2016-05-22 14:30', '2016-05-22 16:00', NULL, '2016-05-19 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `yes_coupon`
--

CREATE TABLE IF NOT EXISTS `yes_coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `coupon_type` varchar(50) DEFAULT NULL COMMENT '券码类型',
  `coupon_price` double DEFAULT NULL COMMENT '券码面值',
  `coupon_number` int(11) DEFAULT NULL COMMENT '验证码',
  `state` int(11) DEFAULT '0' COMMENT '券码状态',
  `order_code` varchar(50) DEFAULT NULL COMMENT '订单编号',
  `app_id` int(11) DEFAULT NULL COMMENT '用户id',
  `project_id` int(11) DEFAULT NULL,
  `receive_time` datetime DEFAULT NULL COMMENT '领取时间',
  `veri_id` varchar(50) DEFAULT '0' COMMENT '验证人id',
  `veri_time` datetime DEFAULT NULL COMMENT '验证时间',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='券码表' AUTO_INCREMENT=116 ;

--
-- 转存表中的数据 `yes_coupon`
--

INSERT INTO `yes_coupon` (`id`, `coupon_type`, `coupon_price`, `coupon_number`, `state`, `order_code`, `app_id`, `project_id`, `receive_time`, `veri_id`, `veri_time`) VALUES
(96, '2', 500, 56926, 0, NULL, 135, 1, '2016-05-18 12:19:16', '0', NULL),
(95, '2', 500, 15197, 0, NULL, 67, 1, '2016-05-18 12:02:42', '0', NULL),
(94, '2', 500, 3468, 0, NULL, 133, 1, '2016-05-18 10:50:26', '0', NULL),
(93, '2', 500, 31183, 0, NULL, NULL, NULL, '2016-05-18 10:31:01', '0', NULL),
(92, '2', 500, 75513, 0, NULL, NULL, NULL, '2016-05-18 10:29:59', '0', NULL),
(91, '2', 500, 58408, 0, NULL, NULL, NULL, '2016-05-18 10:29:07', '0', NULL),
(90, '2', 500, 23608, 0, NULL, 123, 1, '2016-05-17 20:34:58', '0', NULL),
(89, '2', 500, 18569, 0, NULL, 119, 1, '2016-05-17 19:37:49', '0', NULL),
(88, '2', 500, 83092, 0, NULL, 118, 1, '2016-05-17 19:17:24', '0', NULL),
(87, '2', 500, 65865, 0, NULL, 116, 1, '2016-05-17 19:15:57', '0', NULL),
(86, '2', 500, 15889, 0, NULL, 113, 1, '2016-05-17 18:37:26', '0', NULL),
(85, '2', 500, 59645, 0, NULL, 111, 1, '2016-05-17 18:19:10', '0', NULL),
(84, '2', 500, 14537, 0, NULL, 108, 1, '2016-05-17 17:19:41', '0', NULL),
(83, '2', 500, 39711, 0, NULL, 105, 1, '2016-05-17 17:02:23', '0', NULL),
(82, '2', 500, 23657, 0, NULL, 104, 1, '2016-05-17 16:56:11', '0', NULL),
(81, '2', 500, 11098, 0, NULL, 103, 1, '2016-05-17 16:41:59', '0', NULL),
(80, '2', 500, 95585, 0, NULL, 101, 1, '2016-05-17 15:43:50', '0', NULL),
(79, '2', 500, 19051, 0, NULL, 100, 1, '2016-05-17 15:30:59', '0', NULL),
(78, '2', 500, 72205, 0, NULL, 95, 1, '2016-05-17 14:50:50', '0', NULL),
(77, '2', 500, 24617, 0, NULL, 94, 1, '2016-05-17 14:48:58', '0', NULL),
(76, '2', 500, 81655, 0, NULL, 92, 1, '2016-05-17 14:43:45', '0', NULL),
(75, '2', 500, 29818, 0, NULL, 90, 1, '2016-05-17 14:35:35', '0', NULL),
(74, '2', 500, 39399, 0, NULL, 87, 1, '2016-05-17 14:30:57', '0', NULL),
(73, '2', 500, 50402, 0, NULL, 86, 1, '2016-05-17 14:27:41', '0', NULL),
(72, '2', 500, 59097, 0, NULL, 84, 1, '2016-05-17 14:26:24', '0', NULL),
(71, '2', 500, 33010, 0, NULL, 85, 1, '2016-05-17 14:24:46', '0', NULL),
(70, '2', 500, 35701, 0, NULL, 78, 1, '2016-05-17 12:50:39', '0', NULL),
(69, '1', 99, 99774, 0, '160517124957576919P9', 78, 1, '2016-05-17 12:50:14', '0', NULL),
(68, '2', 500, 40545, 0, NULL, 76, 1, '2016-05-17 12:43:47', '0', NULL),
(67, '2', 500, 42700, 0, NULL, 73, 1, '2016-05-17 12:41:11', '0', NULL),
(66, '2', 500, 43608, 0, NULL, 68, 1, '2016-05-17 12:35:37', '0', NULL),
(65, '2', 500, 61651, 0, NULL, 72, 1, '2016-05-17 12:05:44', '0', NULL),
(64, '1', 99, 83571, 0, '1605171149237002414t', 70, 1, '2016-05-17 11:49:41', '0', NULL),
(63, '1', 99, 976680, 0, '160517114913421720Ba', 68, 1, '2016-05-17 11:49:24', '0', NULL),
(62, '1', 99, 193989, 0, '160517114416562089mF', 69, 1, '2016-05-17 11:44:26', '0', NULL),
(97, '2', 500, 69755, 0, NULL, 136, 1, '2016-05-18 12:28:18', '0', NULL),
(98, '2', 500, 20459, 0, NULL, 132, 1, '2016-05-18 12:57:06', '0', NULL),
(1, '1', 99, 976680, 0, '160518105909991212lH', 134, 1, '2016-05-17 11:49:24', '0', NULL),
(99, '1', 99, 468444, 0, '160519103630268461kV', 67, 1, '2016-05-19 10:36:39', '0', NULL),
(100, '2', 500, 97945, 0, NULL, 140, 1, '2016-05-19 11:18:12', '0', NULL),
(101, '2', 500, 55117, 0, NULL, 142, 1, '2016-05-19 11:29:12', '0', NULL),
(102, '2', 500, 85069, 0, NULL, 143, 1, '2016-05-19 11:30:01', '0', NULL),
(103, '2', 500, 59012, 0, NULL, 144, 1, '2016-05-19 11:32:55', '0', NULL),
(104, '2', 500, 51958, 0, NULL, 148, 1, '2016-05-19 12:14:20', '0', NULL),
(105, '2', 500, 70927, 0, NULL, 152, 1, '2016-05-19 15:44:40', '0', NULL),
(107, '2', 500, 94549, 0, NULL, 156, 1, '2016-05-19 21:08:28', '0', NULL),
(108, '2', 500, 92916, 0, NULL, 157, 1, '2016-05-19 21:37:26', '0', NULL),
(109, '2', 500, 77543, 0, NULL, 158, 1, '2016-05-19 21:46:15', '0', NULL),
(110, '2', 500, 35065, 0, NULL, NULL, NULL, '2016-05-20 10:53:51', '0', NULL),
(111, '2', 500, 81725, 0, NULL, 161, 1, '2016-05-20 11:06:15', '0', NULL),
(112, '2', 500, 19795, 0, NULL, 167, 1, '2016-05-20 11:47:01', '0', NULL),
(113, '2', 500, 58284, 0, NULL, 171, 1, '2016-05-20 15:04:26', '0', NULL),
(114, '2', 500, 91184, 0, NULL, 173, 1, '2016-05-20 15:41:44', '0', NULL),
(115, '2', 500, 14930, 0, NULL, 174, 1, '2016-05-20 17:14:24', '0', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `yes_order`
--

CREATE TABLE IF NOT EXISTS `yes_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `order_code` varchar(50) NOT NULL COMMENT '订单编号',
  `project_name` varchar(50) DEFAULT NULL COMMENT '课程名称',
  `order_price` double DEFAULT NULL COMMENT '订单金额',
  `app_id` int(11) DEFAULT NULL COMMENT '用户id',
  `invi_openid` int(11) DEFAULT NULL COMMENT '邀请id',
  `project_id` int(11) DEFAULT NULL,
  `order_status` int(10) DEFAULT '0' COMMENT '订单状态(0未付款,1付款完成)',
  `pay_time` datetime DEFAULT NULL COMMENT '支付时间',
  `create_time` datetime DEFAULT NULL COMMENT '生成时间',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='订单表' AUTO_INCREMENT=317 ;

--
-- 转存表中的数据 `yes_order`
--

INSERT INTO `yes_order` (`id`, `order_code`, `project_name`, `order_price`, `app_id`, `invi_openid`, `project_id`, `order_status`, `pay_time`, `create_time`) VALUES
(284, '160517114431196730PP', '99元书法入门活动课', 1, 69, 67, 1, 0, NULL, '2016-05-17 11:44:31'),
(285, '160517114913421720Ba', '99元书法入门活动课', 1, 68, 67, 1, 1, '2016-05-17 11:49:22', '2016-05-17 11:49:13'),
(286, '1605171149237002414t', '99元书法入门活动课', 1, 70, 67, 1, 1, '2016-05-17 11:49:38', '2016-05-17 11:49:23'),
(287, '160517114926072458fu', '99元书法入门活动课', 1, 68, 67, 1, 0, NULL, '2016-05-17 11:49:26'),
(283, '160517114416562089mF', '99元书法入门活动课', 1, 69, 67, 1, 1, '2016-05-17 11:44:23', '2016-05-17 11:44:16'),
(289, '1605171155212048377M', '99元书法入门活动课', 99, 66, 21, 1, 0, NULL, '2016-05-17 11:55:21'),
(290, '1605171158418124040S', '99元书法入门活动课', 99, 71, 0, 1, 0, NULL, '2016-05-17 11:58:41'),
(291, '160517124321699791oD', '99元书法入门活动课', 99, 76, 73, 1, 0, NULL, '2016-05-17 12:43:21'),
(292, '160517124328242116GE', '99元书法入门活动课', 99, 75, 73, 1, 0, NULL, '2016-05-17 12:43:28'),
(293, '160517124957576919P9', '99元书法入门活动课', 99, 78, 73, 1, 1, '2016-05-17 12:50:12', '2016-05-17 12:49:57'),
(294, '160517144353198364RM', '99元书法入门活动课', 99, 92, 72, 1, 0, NULL, '2016-05-17 14:43:53'),
(295, '160517144417934615pU', '99元书法入门活动课', 99, 92, 72, 1, 0, NULL, '2016-05-17 14:44:17'),
(296, '160517144505366547l6', '99元书法入门活动课', 99, 92, 92, 1, 0, NULL, '2016-05-17 14:45:05'),
(297, '160517144952716665dK', '99元书法入门活动课', 99, 96, 85, 1, 0, NULL, '2016-05-17 14:49:52'),
(308, '160518174910472767VA', '99元书法入门活动课', 99, 140, 72, 1, 0, NULL, '2016-05-18 17:49:10'),
(299, '160517184533557506zs', '99元书法入门活动课', 99, 114, 111, 1, 0, NULL, '2016-05-17 18:45:33'),
(300, '160517193657879317Y7', '99元书法入门活动课', 99, 119, 72, 1, 0, NULL, '2016-05-17 19:36:57'),
(301, '160517213823742908Wu', '99元书法入门活动课', 99, 127, 123, 1, 0, NULL, '2016-05-17 21:38:23'),
(302, '160517231811744526ni', '99元书法入门活动课', 99, 114, 111, 1, 0, NULL, '2016-05-17 23:18:11'),
(304, '160518105326317074Rt', '99元书法入门活动课', 99, 134, 47, 1, 0, NULL, '2016-05-18 10:53:26'),
(305, '1605181054004558183z', '99元书法入门活动课', 99, 134, 47, 1, 0, NULL, '2016-05-18 10:54:00'),
(306, '160518105909991212lH', '99元书法入门活动课', 99, 134, 0, 1, 1, NULL, '2016-05-18 10:59:09'),
(307, '160518130016819046ue', '99元书法入门活动课', 99, 138, 132, 1, 0, NULL, '2016-05-18 13:00:16'),
(309, '160519103630268461kV', '99元书法入门活动课', 99, 67, 0, 1, 1, '2016-05-19 10:36:37', '2016-05-19 10:36:30'),
(310, '1605191341528850890p', '99元书法入门活动课', 99, 72, 72, 1, 0, NULL, '2016-05-19 13:41:52'),
(311, '16051913421835142212', '99元书法入门活动课', 99, 72, 111, 1, 0, NULL, '2016-05-19 13:42:18'),
(312, '160519143012465781gi', '99元书法入门活动课', 99, 150, 72, 1, 0, NULL, '2016-05-19 14:30:12'),
(313, '1605191435400154581R', '99元书法入门活动课', 99, 72, 72, 1, 0, NULL, '2016-05-19 14:35:40'),
(315, '160520141437325718oz', '99元书法入门活动课', 99, 72, 0, 1, 0, NULL, '2016-05-20 14:14:37'),
(316, '1605201542314843216b', '99元书法入门活动课', 99, 173, 72, 1, 0, NULL, '2016-05-20 15:42:31');

-- --------------------------------------------------------

--
-- 表的结构 `yes_project`
--

CREATE TABLE IF NOT EXISTS `yes_project` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `project_name` varchar(50) DEFAULT NULL COMMENT '课程名称',
  `project_type` varchar(50) DEFAULT 'active' COMMENT '课程类型',
  `content` text COMMENT '课程内容',
  `price` double DEFAULT NULL COMMENT '课程价格',
  `uptime` datetime NOT NULL COMMENT '上线时间',
  `default_id` int(11) NOT NULL,
  `state` int(11) DEFAULT '1' COMMENT '课程状态',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY ` id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='课程表' AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `yes_project`
--

INSERT INTO `yes_project` (`id`, `project_name`, `project_type`, `content`, `price`, `uptime`, `default_id`, `state`, `create_time`) VALUES
(1, '99元书法入门活动课', 'active', NULL, 99, '2016-05-04 00:00:00', 1, 1, '2016-05-04 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `yes_school`
--

CREATE TABLE IF NOT EXISTS `yes_school` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `lg` varchar(50) DEFAULT NULL COMMENT '经度',
  `school_name` varchar(50) DEFAULT NULL COMMENT '学校名称',
  `province` varchar(50) DEFAULT NULL COMMENT '省份',
  `city` varchar(50) DEFAULT NULL COMMENT '城市',
  `area` varchar(50) DEFAULT NULL COMMENT '地区',
  `lt` varchar(50) DEFAULT NULL COMMENT '维度',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='学校表' AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `yes_school`
--

INSERT INTO `yes_school` (`id`, `lg`, `school_name`, `province`, `city`, `area`, `lt`, `create_time`) VALUES
(1, '116.460939', '国贸校区 ', '北京市', '朝阳区', '建外SOHO西区', '39.911165', '2016-05-06 13:25:16'),
(2, '116.444148', '东四十条校区', '北京市', '东城区', '东中街58号 美惠大厦', '39.936448', '2016-05-06 13:25:47'),
(3, '116.417879', '亚运村校区', '北京市', '朝阳区', '大屯路安慧北里安园大屯邻里中心', '40.007231', '2016-05-06 17:06:23'),
(4, '116.286452', '五棵松校区', '北京市', '海淀区', '西翠路17号院紫金长安小区底商', '39.922585', '2016-05-06 17:06:56'),
(5, '116.384758 ', '德胜门校区', '北京市', '西城区', '德外大街87号德胜国际底商', '39.960994', '2016-05-06 17:07:32'),
(6, '116.426272', '天坛校区', '北京市', '东城区', '天坛东路甲7号(燕京书画社)', '39.888551', '2016-05-06 17:07:58'),
(7, '116.309627', '苏州桥校区', '北京市', '海淀区', '长春桥路新起点嘉园10号楼', '39.967505', '2016-05-06 17:08:32'),
(8, '116.422534', '天通苑校区', '北京市', '昌平区', '天通中苑F区（京妮儿童汇）', '40.075263', '2016-05-06 17:09:14'),
(9, '116.463627', '太阳宫校区', '北京市', '朝阳区', '太阳宫金星园9号楼', '39.974185', '2016-05-06 17:09:39'),
(10, '116.279324', '百旺校区', '北京市', '海淀区', '圆明园西路梅园甲3-2香林苑', '40.037822', '2016-05-06 17:10:03');

-- --------------------------------------------------------

--
-- 表的结构 `yes_user`
--

CREATE TABLE IF NOT EXISTS `yes_user` (
  `id` varchar(50) NOT NULL COMMENT '主键',
  `name` varchar(50) DEFAULT NULL COMMENT '用户名',
  `passwd` varchar(50) DEFAULT NULL COMMENT '密码',
  `school_id` int(11) NOT NULL COMMENT '学校id',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='管理员';

--
-- 转存表中的数据 `yes_user`
--

INSERT INTO `yes_user` (`id`, `name`, `passwd`, `school_id`, `create_time`) VALUES
('1', 'admin', '202cb962ac59075b964b07152d234b70', 0, '2016-04-19 08:49:44'),
('7D7F9E78-6F41-5283-F27E-E994B1D3D6E0', 'yycyanning', '15ce9c9f3855b775935cc9011dd4d6cb', 0, '2016-05-11 17:02:20'),
('06B4FEE7-529A-9677-6CC0-144A0F4EB221', 'yyczhangcaijuan', '95df424c8709621cd3e0a0091f8cdab3', 0, '2016-05-11 17:02:58'),
('C7F178D5-7AE3-0596-C40F-94241A670BF5', 'ttyyanxiaoyan', '5e194a21985e4f37bb5c965c942cf376', 0, '2016-05-11 17:03:47'),
('8DA44262-CFCA-71EF-CBFC-7F88C123BEDE', 'ttyzhaoxinlei', '0121d102e93262bcaf44b652d8e560e1', 0, '2016-05-11 17:04:50'),
('B132F726-A3BD-F56C-C5C4-7ED951FD71D5', 'ttywangchuang', 'b52d2d3b152696b22a27d280a171ece2', 0, '2016-05-11 17:05:24'),
('5CF8E04D-7B55-81DD-2B20-B5CE9D0DF4C8', 'ttyzuotianduo', '6e789db9b7a998614cbfa0f17a9786d9', 0, '2016-05-11 17:06:01'),
('D33545D8-B19A-7890-DE96-786C8A1C0198', 'wkslimengmeng', 'e24726f635489e359939b0fe6a76304d', 0, '2016-05-11 17:06:49'),
('0C2B41FC-43DE-15CB-DF39-4196E9533448', 'wksliuwendi', 'cd63f7ee558abea59f53a41a86089d6b', 0, '2016-05-11 17:08:14'),
('A06B2708-5C8A-4B2A-C787-EBE814EBDFA2', 'wkszhengqinhe', 'ed7ec8f3879f5dfd94b9458c32c3467c', 0, '2016-05-11 17:08:51'),
('E2E456D3-4DFB-A2B5-ED7B-6A0550A2AF67', 'gmzhangxuefeng', '0e4bd5341e3142b63857904d435d39ad', 0, '2016-05-11 17:09:56'),
('4472FA40-170F-B048-C299-53331844EFB8', 'gmjiamingru', '91523450e68ee045742c37d8d24c0120', 0, '2016-05-11 17:10:37'),
('1A030DD4-6C7D-121C-5756-75BD4940CDC8', 'gmfujingxiang', '294b88630f796271e0acd93f107cab37', 0, '2016-05-11 17:11:18'),
('009F69A3-3B59-026F-1A73-EF7216B52EE2', 'szqluoxutao', '0de9e7280eb08334cdf075405db281a6', 0, '2016-05-11 17:11:59'),
('F92FCEA8-FB47-8C1D-572C-D52A1509B67A', 'szqlihui', '6c9aaca1a2320e15850e8157d73b2333', 0, '2016-05-11 17:12:31'),
('16B420CC-A676-7106-18B2-3846F3F9B4A1', 'tygdingyongxiu', '8a2729ca601599c3f57cad685b9fb94c', 0, '2016-05-11 17:17:21'),
('8F8B00A6-F58D-9022-93E9-1A5CD5C0E05C', 'tygzhangwei', '947b3ee638293fd219461f529396d71c', 0, '2016-05-11 17:17:58'),
('7CA69BAD-E7F8-4F89-1717-2B38864405BF', 'dswangfang', '3b4b01d135b3dc4906155767967c4afe', 0, '2016-05-11 17:46:58'),
('DAD73A4E-56B4-5E7C-0215-7C368BA3D853', 'dsfengchenxi', '3b4b01d135b3dc4906155767967c4afe', 0, '2016-05-11 17:47:24'),
('D4FE86EF-5187-839E-774A-00115BCD4F54', 'tylixinyi', 'fb671e2da4796208031310b0e41381ef', 0, '2016-05-12 11:39:02'),
('C3B2DBF1-0C31-CF0B-EFC9-F7DD6126E88F', 'tyzhangjingjing', 'e7c35403fd8381f69ba542c9064a38cb', 0, '2016-05-12 11:39:53'),
('8A7D96FC-FEE5-06D8-F87A-66718163C032', 'ttbaixue', 'c5f1cfa53d944afa5bf79192769cbdd5', 0, '2016-05-12 11:44:16'),
('562BADA3-EFA2-C172-04EC-4191E4B9AA56', 'ttsunaran', 'decab7b740d3ee707d3031ba034011f1', 0, '2016-05-12 11:45:08'),
('D9BEBED2-CB30-B259-6C6F-D101001A18E5', 'tthexiaofei', 'c811457775a2a5e8bfebdc748147f3a4', 0, '2016-05-12 11:46:13'),
('56BD5D6A-6D7A-3014-70AD-69083DC459B2', 'liminghui', 'e10adc3949ba59abbe56e057f20f883e', 0, '2016-05-17 12:10:31'),
('2E33A0D0-6698-7D31-BC45-3E956129E32A', 'huanglinqian', 'e10adc3949ba59abbe56e057f20f883e', 0, '2016-05-17 12:10:51'),
('5821763E-858E-6DEF-5E55-2F26C52EED35', 'liuruanxin', 'e10adc3949ba59abbe56e057f20f883e', 0, '2016-05-17 12:11:06');
