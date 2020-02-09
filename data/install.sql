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