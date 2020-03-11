--
-- Add new tab
--
INSERT INTO `core_form_tab` (`Tab_ID`, `form`, `title`, `subtitle`, `icon`, `counter`, `sort_id`, `filter_check`, `filter_value`) VALUES
('basket-position', 'basket-single', 'Positions', 'Basket Items', 'fas fa-list', '', '1', '', '');

--
-- Add new partial
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'partial', 'Positions', 'basket_position', 'basket-position', 'basket-single', 'col-md-12', '', '', '0', '1', '0', '', '', '');

--
-- create position table
--
CREATE TABLE `basket_position` (
  `Position_ID` int(11) NOT NULL,
  `basket_idfs` int(11) NOT NULL DEFAULT 0,
  `article_idfs` int(11) NOT NULL DEFAULT 0,
  `article_type` VARCHAR(20) NOT NULL DEFAULT 'article',
  `amount` FLOAT NOT NULL DEFAULT 0,
  `price` FLOAT NOT NULL DEFAULT 0,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `basket_position`
  ADD PRIMARY KEY (`Position_ID`);

ALTER TABLE `basket_position`
  MODIFY `Position_ID` int(11) NOT NULL AUTO_INCREMENT;


--
-- core form for position
--
INSERT INTO `core_form` (`form_key`, `label`, `entity_class`, `entity_tbl_class`) VALUES
('basketposition-single', 'Basket Position', 'OnePlace\\Basket\\Position\\Model\\Position', 'OnePlace\\Contact\\Position\\Model\\PositionTable');

--
-- tab for positions
--
INSERT INTO `core_form_tab` (`Tab_ID`, `form`, `title`, `subtitle`, `icon`, `counter`, `sort_id`, `filter_check`, `filter_value`) VALUES
('position-base', 'basketposition-single', 'Position', 'Base data', 'fas fa-list', '', '1', '', '');

--
-- form fields for position
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'number', 'Amount', 'amount', 'position-base', 'basketposition-single', 'col-md-1', '', '', '0', '1', '0', '', '', ''),
(NULL, 'currency', 'Price', 'price', 'position-base', 'basketposition-single', 'col-md-1', '', '', '0', '1', '0', '', '', ''),
(NULL, 'text', 'Comment', 'comment', 'position-base', 'basketposition-single', 'col-md-3', '', '', '0', '1', '0', '', '', ''),
(NULL, 'select', 'Article', 'article_idfs', 'position-base', 'basketposition-single', 'col-md-5', '', '/api/article/list', '0', '1', '0', 'article-single', 'OnePlace\\Article\\Model\\ArticleTable','add-OnePlace\\Article\\Controller\\ArticleController'),
(NULL, 'currency', 'Total', 'total', 'position-base', 'basketposition-single', 'col-md-2', '', '', '0', '1', '0', '', '', '');