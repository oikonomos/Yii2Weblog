--
-- Database : `Yii2Weblog`
--

-- --------------------------------------------------------

--
-- Structure of table `auth_assignment`
--

CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump data of table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('superadmin', '1', 1502869704);

-- --------------------------------------------------------

--
-- Structure of table `auth_item`
--

CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump data of table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, 'The authority to administrate', NULL, NULL, 1456973673, 1456973673),
('attachMedia', 2, 'The authority to attach media.', NULL, NULL, 1496802505, 1496802505),
('author', 1, 'The authority to edit', NULL, NULL, 1456973673, 1456973673),
('browserStatistics', 2, 'The authority to view browser log', NULL, NULL, 1495238672, 1495238672),
('cindexTaxonomy', 2, 'The authority to list retrieved by category.', NULL, NULL, 1513838318, 1513838318),
('configOption', 2, 'Site configuration variables.', NULL, NULL, 1507525650, 1507525650),
('cookiePopup', 2, 'The authority to  access cookie action.', NULL, NULL, 1512370432, 1512370432),
('counterStatistics', 2, 'The authority to view counter log', NULL, NULL, 1495238672, 1495238672),
('createAssignment', 2, 'The authority to create auth item.', NULL, NULL, 1495238672, 1495238672),
('createComment', 2, 'The authority to create comment', NULL, NULL, 1456973673, 1456973673),
('createLink', 2, 'The authority to create link', NULL, NULL, 1495238672, 1495238672),
('createMedia', 2, 'The authority to create media', NULL, NULL, 1456973673, 1456973673),
('createMenu', 2, 'The authority to create menu', NULL, NULL, 1495238672, 1495238672),
('createOption', 2, 'The authority to create option', NULL, NULL, 1457485615, 1457485615),
('createPermission', 2, 'The authority to create auth item', NULL, NULL, 1495238672, 1495238672),
('createPopup', 2, 'The authority to create popup', NULL, NULL, 1456973673, 1456973673),
('createPost', 2, 'The authority to create post', NULL, NULL, 1456973672, 1456973672),
('createRelation', 2, 'The authority to create auth item child', NULL, NULL, 1495238672, 1495238672),
('createRule', 2, 'The authority to create auth rule', NULL, NULL, 1495238672, 1495238672),
('createTaxonomy', 2, 'The authority to create taxonomy', NULL, NULL, 1495238672, 1495238672),
('createUser', 2, 'The authority to create user', NULL, NULL, 1495238672, 1495238672),
('dashboard2Site', 2, 'The authority to view dashboard page.', NULL, NULL, 1512004655, 1512004655),
('dashboardSite', 2, 'The authority to access dashboard page', NULL, NULL, 1456974653, 1456974653),
('deleteallAssignment', 2, 'The authority to delete all selected assignments', NULL, NULL, 1495238672, 1495238672),
('deleteallComment', 2, 'The authority to delete comment', NULL, NULL, 1456973673, 1456973673),
('deleteallLink', 2, 'The authority to delete all selected links', NULL, NULL, 1495238672, 1495238672),
('deleteallMedia', 2, 'The authority to delete all selected media', NULL, NULL, 1456973673, 1456973673),
('deleteallMenu', 2, 'The authority to delete all selected menus.', NULL, NULL, 1495244380, 1495244380),
('deleteallOption', 2, 'The authority to delete all selected options', NULL, NULL, 1457486863, 1457486863),
('deleteallOwnComment', 2, 'The authority to delete only one''s own all selected comments', 'isAuthor', NULL, 1467108419, 1467108419),
('deleteallOwnMedia', 2, 'The authority to delete only one''s own media', 'isAuthor', NULL, 1456973673, 1456973673),
('deleteallOwnMenu', 2, 'The authority to delete all selected menus.', 'isAuthor', NULL, 1495244380, 1495244380),
('deleteallOwnPost', 2, 'The authority to delete only one''s own post', 'isAuthor', NULL, 1456973673, 1456973673),
('deleteallPermission', 2, 'The authority to delete all selected auth items', NULL, NULL, 1495238672, 1495238672),
('deleteallPopup', 2, 'The authority to delete only one''s own popup', NULL, NULL, 1456973673, 1456973673),
('deleteallPost', 2, 'The authority to delete only one''s own post', NULL, NULL, 1456973673, 1456973673),
('deleteallRelation', 2, 'The authority to delete all selected auth item childs', NULL, NULL, 1495238672, 1495238672),
('deleteallRule', 2, 'The authority to delete all selected auth rules', NULL, NULL, 1495238672, 1495238672),
('deleteallTaxonomy', 2, 'The authority to delete all selected taxonomys', NULL, NULL, 1495238672, 1495238672),
('deleteallUser', 2, 'The authority to delete all selected users.', NULL, NULL, 1495244380, 1495244380),
('deleteAssignment', 2, 'The authority to delete all selected assignments', NULL, NULL, 1495238672, 1495238672),
('deleteComment', 2, 'The authority to delete comment', NULL, NULL, 1456973673, 1456973673),
('deleteLink', 2, 'The authority to delete link', NULL, NULL, 1495238672, 1495238672),
('deleteMedia', 2, 'The authority to delete media', NULL, NULL, 1456973673, 1456973673),
('deleteMenu', 2, 'The authority to delete menu', NULL, NULL, 1495238672, 1495238672),
('deleteOption', 2, 'The authority to delete option', NULL, NULL, 1457486815, 1457486815),
('deleteOwnComment', 2, 'The authority to delete only one''s own comments', 'isAuthor', NULL, 1467108353, 1467108353),
('deleteOwnMedia', 2, 'The authority to delete only one''s own media', 'isAuthor', NULL, 1456973673, 1456973673),
('deleteOwnMenu', 2, 'The authority to delete menu', 'isAuthor', NULL, 1495238672, 1495238672),
('deleteOwnPost', 2, 'The authority to delete only one''s own post', 'isAuthor', NULL, 1456973673, 1456973673),
('deletePermission', 2, 'The authority to delete auth item', NULL, NULL, 1495238672, 1495238672),
('deletePopup', 2, 'The authority to delete popup', NULL, NULL, 1456973673, 1456973673),
('deletePost', 2, 'The authority to delete post', NULL, NULL, 1456973673, 1456973673),
('deleteRelation', 2, 'The authority to delete auth item child', NULL, NULL, 1495238672, 1495238672),
('deleteRule', 2, 'The authority to delete auth rule', NULL, NULL, 1495238672, 1495238672),
('deleteTaxonomy', 2, 'The authority to delete taxonomy', NULL, NULL, 1495238672, 1495238672),
('deleteUser', 2, 'The authority to delete user', NULL, NULL, 1495238672, 1495238672),
('domainStatistics', 2, 'The authority to view domain log', NULL, NULL, 1495238672, 1495238672),
('errorSite', 2, 'The authority to process error', NULL, NULL, 1457419759, 1457419759),
('galleryPost', 2, 'The authority to view gallery list.', NULL, NULL, 1511752586, 1511752586),
('getComment', 2, 'The authority to get comment', NULL, NULL, 1466506853, 1466506951),
('getOwnComment', 2, 'The authority to get only one''s own comment', 'isAuthor', NULL, 1466506991, 1467011022),
('gsearchSite', 2, 'The Authority to search posts by the given  search string.', NULL, NULL, 1511142235, 1511142235),
('guest', 1, 'The authority to be rendered to guest', NULL, NULL, 1457683084, 1457683084),
('indexAssignment', 2, 'The permission viewing assignments list.', NULL, NULL, 1495238548, 1495238548),
('indexComment', 2, 'The authority to view comment list', NULL, NULL, 1456973673, 1456973673),
('indexLink', 2, 'The authority to view link list', NULL, NULL, 1495238672, 1495238672),
('indexMedia', 2, 'The authority to view media list', NULL, NULL, 1456973673, 1456973673),
('indexMenu', 2, 'The authority to view menu list', NULL, NULL, 1456973673, 1456973673),
('indexOption', 2, 'The authority to view option list', NULL, NULL, 1457485531, 1457485531),
('indexOwnComment', 2, 'The authority to view one''s own comment list', 'isAuthor', NULL, 1467108181, 1467108181),
('indexOwnMedia', 2, 'The authority to view only one''s own mdia list', 'isAuthor', NULL, 1456973673, 1456973673),
('indexOwnMenu', 2, 'The authority to view only one''s own menu list', 'isAuthor', NULL, 1456973673, 1456973673),
('indexOwnPost', 2, 'The authority to view only one''s own post list', 'isAuthor', NULL, 1456973673, 1456973673),
('indexPermission', 2, 'The authority to view auth item list', NULL, NULL, 1495238672, 1495238672),
('indexPopup', 2, 'The authority to view popup list', NULL, NULL, 1456973673, 1456973673),
('indexPost', 2, 'The authority to view pos ist', NULL, NULL, 1456973673, 1456973673),
('indexRelation', 2, 'The authority to view auth item child list', NULL, NULL, 1495238672, 1495238672),
('indexRule', 2, 'The authority to view auth rule list', NULL, NULL, 1495238672, 1495238672),
('indexStatistics', 2, 'The authority to view websight log', NULL, NULL, 1495238672, 1495238672),
('indexTaxonomy', 2, 'The authority to view taxonomy list', NULL, NULL, 1495238672, 1495238672),
('indexUser', 2, 'The authority to view user list', NULL, NULL, 1457488716, 1457488716),
('indexWeblog', 2, 'The authority to view wesight log', NULL, NULL, 1456973673, 1456973673),
('ipStatistics', 2, 'The authority to view ip log', NULL, NULL, 1495238672, 1495238672),
('keywordStatistics', 2, 'The authority to view keyword log', NULL, NULL, 1495238672, 1495238672),
('listPost', 2, 'The authority to view bbs list', NULL, NULL, 1457683036, 1457683036),
('MdeleteMedia', 2, 'The authority to delete file through multiple  file upload form.', NULL, NULL, 1496197302, 1496197302),
('modifyComment', 2, 'The authority to modify comment', NULL, NULL, 1465516189, 1465516189),
('modifyOwnComment', 2, 'The authority to modify only one''s own comment', 'isAuthor', NULL, 1466581372, 1467011051),
('osStatistics', 2, 'The authority to view os log', NULL, NULL, 1495238672, 1495238672),
('pagePost', 2, 'The authority to view page list.', NULL, NULL, 1511407568, 1511407568),
('pageStatistics', 2, 'The authority to view page log', NULL, NULL, 1495238672, 1495238672),
('pcreatePost', 2, 'The authority to create page.', NULL, NULL, 1511407663, 1511752251),
('profileUser', 2, 'The authority to update user profile.', NULL, NULL, 1496050217, 1496050217),
('pupdatePost', 2, 'The authority to update page.', NULL, NULL, 1511407704, 1511752282),
('pviewPost', 2, 'The authority to view page infomation.', NULL, NULL, 1511407740, 1511752304),
('refererStatistics', 2, 'The authority to view referer log', NULL, NULL, 1495238672, 1495238672),
('removeComment', 2, 'The authority to remove comment', NULL, NULL, 1466492107, 1466492107),
('removeOwnComment', 2, 'The authority to remove only one''s own comment', 'isAuthor', NULL, 1466492198, 1467011841),
('removeOwnPost', 2, 'The authority to remove only one''s own post.', 'isAuthor', NULL, 1467016054, 1467016054),
('removePost', 2, 'The authority to remove post', NULL, NULL, 1467015999, 1467015999),
('searchenginStatistics', 2, 'The authority to view searchengin log', NULL, NULL, 1495238672, 1495238672),
('signupSite', 2, 'The authority to help one to join in member', NULL, NULL, 1460438072, 1460438072),
('superadmin', 1, 'The superadmin authority to do all things', NULL, NULL, 1456973673, 1456973673),
('updateAssignment', 2, 'The authority to update auth assignment.', NULL, NULL, 1495240722, 1495240722),
('updateComment', 2, 'The authority to update comment', NULL, NULL, 1456973673, 1456973673),
('updateLink', 2, 'The authority to update link', NULL, NULL, 1495238672, 1495238672),
('updateMedia', 2, 'The authority to update media', NULL, NULL, 1456973673, 1456973673),
('updateMenu', 2, 'The authority to update menu', NULL, NULL, 1495238672, 1495238672),
('updateOption', 2, 'The authority to update option', NULL, NULL, 1457485652, 1457485652),
('updateOwnComment', 2, 'The authority to update only one''s own comment', 'isAuthor', NULL, 1467108728, 1467108728),
('updateOwnLink', 2, 'The authority to update only one''s own link', 'isAuthor', NULL, 1495238672, 1495238672),
('updateOwnMedia', 2, 'The authority to update only one''s own media', 'isAuthor', NULL, 1456973673, 1456973673),
('updateOwnMenu', 2, 'The authority to update only one''s own menu list', 'isAuthor', NULL, 1456973673, 1456973673),
('updateOwnPost', 2, 'The authority to update only own post', 'isAuthor', NULL, 1456973673, 1456973673),
('updateOwnUser', 2, 'The authority to update own user information.  ', 'isAuthor', NULL, 1496050126, 1496050126),
('updatePermission', 2, 'The authority to update auth item', NULL, NULL, 1495238672, 1495238672),
('updatePopup', 2, 'The authority to update popup', NULL, NULL, 1456973673, 1456973673),
('updatePost', 2, 'The authority to update post', NULL, NULL, 1456973673, 1456973673),
('updateRelation', 2, 'The authority to update auth item child', NULL, NULL, 1495238672, 1495238672),
('updateRule', 2, 'The authority to update auth rule', NULL, NULL, 1495238672, 1495238672),
('updateTaxonomy', 2, 'The authority to update taxonomy', NULL, NULL, 1495238672, 1495238672),
('updateUser', 2, 'The authority to update user', NULL, NULL, 1495238672, 1495238672),
('view_contentPost', 2, 'The authority to view post content', NULL, NULL, 1460342719, 1460342719),
('viewAssignment', 2, 'The authority to view auth assignment', NULL, NULL, 1495238672, 1495238672),
('viewComment', 2, 'The authority to view comment ', NULL, NULL, 1456973673, 1456973673),
('viewLink', 2, 'The authority to view link', NULL, NULL, 1495238672, 1495238672),
('viewMedia', 2, 'The authority to view media', NULL, NULL, 1456973673, 1456973673),
('viewMenu', 2, 'The authority to view menu', NULL, NULL, 1456973673, 1456973673),
('viewOption', 2, 'The authority to view option', NULL, NULL, 1457485573, 1457485573),
('viewOwnComment', 2, 'The authority to view only one''s own comment', 'isAuthor', NULL, 1467108649, 1467108649),
('viewOwnMedia', 2, 'The authority to view only one''s own media', 'isAuthor', NULL, 1456973673, 1456973673),
('viewOwnMenu', 2, 'The authority to view only one''s own menu', 'isAuthor', NULL, 1456973673, 1456973673),
('viewOwnPost', 2, 'The authority to view only one''s own post', 'isAuthor', NULL, 1456973673, 1464838489),
('viewPermission', 2, 'The authority to view auth item', NULL, NULL, 1495238672, 1495238672),
('viewPopup', 2, 'The authority to view popup', NULL, NULL, 1456973673, 1456973673),
('viewPost', 2, 'The authority to view post', NULL, NULL, 1456973673, 1464838702),
('viewRelation', 2, 'The authority to view auth item child', NULL, NULL, 1495238672, 1495238672),
('viewRule', 2, 'The authority to view auth rule', NULL, NULL, 1495238672, 1495238672),
('viewTaxonomy', 2, 'The authority to view taxonomy', NULL, NULL, 1495238672, 1495238672),
('viewUser', 2, 'The authority to view user', NULL, NULL, 1495238672, 1495238672),
('viewWeblog', 2, 'The authority to view weblog', NULL, NULL, 1456973673, 1456973673),
('writeComment', 2, 'The authority to comment', NULL, NULL, 1465515844, 1465515844),
('writePost', 2, 'The authority to write post', NULL, NULL, 1460107237, 1460107237);

-- --------------------------------------------------------

--
-- Structure of table `auth_item_child`
--

CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump data of table `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('superadmin', 'admin'),
('author', 'attachMedia'),
('superadmin', 'author'),
('superadmin', 'browserStatistics'),
('superadmin', 'cindexTaxonomy'),
('superadmin', 'configOption'),
('guest', 'cookiePopup'),
('superadmin', 'counterStatistics'),
('superadmin', 'createAssignment'),
('author', 'createComment'),
('author', 'createLink'),
('author', 'createMedia'),
('superadmin', 'createOption'),
('superadmin', 'createPermission'),
('superadmin', 'createPopup'),
('author', 'createPost'),
('superadmin', 'createRelation'),
('superadmin', 'createRule'),
('superadmin', 'createTaxonomy'),
('superadmin', 'createUser'),
('author', 'dashboard2Site'),
('author', 'dashboardSite'),
('superadmin', 'deleteallAssignment'),
('deleteallOwnComment', 'deleteallComment'),
('superadmin', 'deleteallComment'),
('superadmin', 'deleteallLink'),
('deleteallOwnMedia', 'deleteallMedia'),
('superadmin', 'deleteallMedia'),
('deleteallOwnMenu', 'deleteallMenu'),
('superadmin', 'deleteallOption'),
('author', 'deleteallOwnComment'),
('author', 'deleteallOwnMedia'),
('author', 'deleteallOwnMenu'),
('author', 'deleteallOwnPost'),
('superadmin', 'deleteallPermission'),
('superadmin', 'deleteallPopup'),
('deleteallOwnPost', 'deleteallPost'),
('superadmin', 'deleteallPost'),
('superadmin', 'deleteallRelation'),
('superadmin', 'deleteallRule'),
('superadmin', 'deleteallTaxonomy'),
('superadmin', 'deleteallUser'),
('superadmin', 'deleteAssignment'),
('deleteOwnComment', 'deleteComment'),
('superadmin', 'deleteComment'),
('superadmin', 'deleteLink'),
('deleteOwnMedia', 'deleteMedia'),
('superadmin', 'deleteMedia'),
('deleteOwnMenu', 'deleteMenu'),
('superadmin', 'deleteMenu'),
('superadmin', 'deleteOption'),
('author', 'deleteOwnComment'),
('author', 'deleteOwnMenu'),
('author', 'deleteOwnPost'),
('superadmin', 'deletePermission'),
('superadmin', 'deletePopup'),
('deleteOwnPost', 'deletePost'),
('superadmin', 'deletePost'),
('superadmin', 'deleteRelation'),
('superadmin', 'deleteRule'),
('superadmin', 'deleteTaxonomy'),
('superadmin', 'deleteUser'),
('superadmin', 'domainStatistics'),
('guest', 'galleryPost'),
('getOwnComment', 'getComment'),
('superadmin', 'getComment'),
('author', 'getOwnComment'),
('author', 'gsearchSite'),
('author', 'guest'),
('superadmin', 'indexAssignment'),
('author', 'indexComment'),
('superadmin', 'indexLink'),
('author', 'indexMedia'),
('indexOwnMenu', 'indexMenu'),
('superadmin', 'indexMenu'),
('superadmin', 'indexOption'),
('author', 'indexOwnMenu'),
('superadmin', 'indexPermission'),
('admin', 'indexPopup'),
('admin', 'indexPost'),
('author', 'indexPost'),
('superadmin', 'indexRelation'),
('superadmin', 'indexRule'),
('superadmin', 'indexStatistics'),
('superadmin', 'indexTaxonomy'),
('superadmin', 'indexUser'),
('superadmin', 'indexWeblog'),
('superadmin', 'ipStatistics'),
('superadmin', 'keywordStatistics'),
('guest', 'listPost'),
('author', 'MdeleteMedia'),
('modifyOwnComment', 'modifyComment'),
('superadmin', 'modifyComment'),
('author', 'modifyOwnComment'),
('superadmin', 'osStatistics'),
('superadmin', 'pagePost'),
('superadmin', 'pageStatistics'),
('superadmin', 'pcreatePost'),
('author', 'profileUser'),
('superadmin', 'pupdatePost'),
('superadmin', 'pviewPost'),
('superadmin', 'refererStatistics'),
('removeOwnComment', 'removeComment'),
('superadmin', 'removeComment'),
('author', 'removeOwnComment'),
('author', 'removeOwnPost'),
('removeOwnPost', 'removePost'),
('superadmin', 'removePost'),
('superadmin', 'searchenginStatistics'),
('guest', 'signupSite'),
('superadmin', 'updateAssignment'),
('superadmin', 'updateComment'),
('updateOwnComment', 'updateComment'),
('superadmin', 'updateLink'),
('updateOwnLink', 'updateLink'),
('superadmin', 'updateMedia'),
('updateOwnMedia', 'updateMedia'),
('superadmin', 'updateMenu'),
('updateOwnMenu', 'updateMenu'),
('superadmin', 'updateOption'),
('author', 'updateOwnComment'),
('author', 'updateOwnLink'),
('author', 'updateOwnMedia'),
('author', 'updateOwnMenu'),
('author', 'updateOwnPost'),
('author', 'updateOwnUser'),
('superadmin', 'updatePermission'),
('superadmin', 'updatePopup'),
('superadmin', 'updatePost'),
('updateOwnPost', 'updatePost'),
('superadmin', 'updateRelation'),
('superadmin', 'updateRule'),
('superadmin', 'updateTaxonomy'),
('superadmin', 'updateUser'),
('updateOwnUser', 'updateUser'),
('guest', 'view_contentPost'),
('superadmin', 'viewAssignment'),
('superadmin', 'viewComment'),
('viewOwnComment', 'viewComment'),
('superadmin', 'viewLink'),
('admin', 'viewMedia'),
('viewOwnMedia', 'viewMedia'),
('superadmin', 'viewMenu'),
('superadmin', 'viewOption'),
('author', 'viewOwnComment'),
('author', 'viewOwnMedia'),
('author', 'viewOwnMenu'),
('author', 'viewOwnPost'),
('superadmin', 'viewPermission'),
('admin', 'viewPopup'),
('superadmin', 'viewPost'),
('viewOwnPost', 'viewPost'),
('superadmin', 'viewRelation'),
('superadmin', 'viewRule'),
('superadmin', 'viewTaxonomy'),
('superadmin', 'viewUser'),
('superadmin', 'viewWeblog'),
('author', 'writeComment'),
('author', 'writePost');

-- --------------------------------------------------------

--
-- Structure of table `auth_rule`
--

CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump data of table `auth_rule`
--

INSERT INTO `auth_rule` (`name`, `data`, `created_at`, `updated_at`) VALUES
('isAuthor', 0x4f3a31393a226170705c726261635c417574686f7252756c65223a333a7b733a343a226e616d65223b733a383a226973417574686f72223b733a393a22637265617465644174223b693a313531373938333432303b733a393a22757064617465644174223b693a313531373939303338313b7d, 1517983420, 1517990381);

-- --------------------------------------------------------

--
-- Structure of table `color`
--

CREATE TABLE IF NOT EXISTS `color` (
  `color_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `style` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`color_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=149 ;

--
-- Dump data of table `color`
--

INSERT INTO `color` (`color_id`, `name`, `value`, `description`, `style`) VALUES
(1, 'aliceblue', 'f0f8ff', 'ALICEBLUE', 'background-color: #f0f8ff'),
(2, 'antiquewhite', 'faebd7', 'ANTIQUEWHITE', 'background-color: #faebd7'),
(3, 'aqua', '00ffff', 'AQUA', 'background-color: #00ffff'),
(4, 'aquamarine', '7fffd4', 'AQUAMARINE', 'background-color: #7fffd4'),
(5, 'azure', 'f0ffff', 'AZURE', 'background-color: #f0ffff'),
(6, 'beige', 'f5f5dc', 'BEIGE', 'background-color: #f5f5dc'),
(7, 'bisque', 'ffe4c4', 'BISQUE', 'background-color: #ffe4c4'),
(8, 'black', '000000', 'BLACK', 'background-color: #000000'),
(9, 'blanchedalmond', 'ffebcd', 'BLANCHEDALMOND', 'background-color: #ffebcd'),
(10, 'blue', '0000ff', 'BLUE', 'background-color: #0000ff'),
(11, 'blueviolet', '8a2be2', 'BLUEVIOLET', 'background-color: #8a2be2'),
(12, 'brown', 'a52a2a', 'BROWN', 'background-color: #a52a2a'),
(13, 'burlywood', 'deb887', 'BURLYWOOD', 'background-color: #deb887'),
(14, 'cadetblue', '5f9ea0', 'CADETBLUE', 'background-color: #5f9ea0'),
(15, 'chartreuse', '7fff00', 'CHARTREUSE', 'background-color: #7fff00'),
(16, 'chocolate', 'd2691e', 'CHOCOLATE', 'background-color: #d2691e'),
(17, 'coral', 'ff7f50', 'CORAL', 'background-color: #ff7f50'),
(18, 'cornflowerblue', '6495ed', 'CORNFLOWERBLUE', 'background-color: #6495ed'),
(19, 'cornsilk', 'fff8dc', 'CORNSILK', 'background-color: #fff8dc'),
(20, 'crimson', 'dc143c', 'CRIMSON', 'background-color: #dc143c'),
(21, 'cyan', '00ffff', 'CYAN', 'background-color: #00ffff'),
(22, 'darkblue', '00008b', 'DARKBLUE', 'background-color: #00008b'),
(23, 'darkcyan', '008b8b', 'DARKCYAN', 'background-color: #008b8b'),
(24, 'darkgoldenrod', 'b8860b', 'DARKGOLDENROD', 'background-color: #b8860b'),
(25, 'darkgray', 'a9a9a9', 'DARKGRAY', 'background-color: #a9a9a9'),
(26, 'darkgreen', '006400', 'DARKGREEN', 'background-color: #006400'),
(27, 'darkkhaki', 'bdb76b', 'DARKKHAKI', 'background-color: #bdb76b'),
(28, 'darkmagenta', '8b008b', 'DARKMAGENTA', 'background-color: #8b008b'),
(29, 'darkolivegreen', '556b2f', 'DARKOLIVEGREEN', 'background-color: #556b2f'),
(30, 'darkorange', 'ff8c00', 'DARKORANGE', 'background-color: #ff8c00'),
(31, 'darkorchid', '9932cc', 'DARKORCHID', 'background-color: #9932cc'),
(32, 'darkred', '8b0000', 'DARKRED', 'background-color: #8b0000'),
(33, 'darksalmon', 'e9967a', 'DARKSALMON', 'background-color: #e9967a'),
(34, 'darkseagreen', '8fbc8b', 'DARKSEAGREEN', 'background-color: #8fbc8b'),
(35, 'darkslateblue', '483d8b', 'DARKSLATEBLUE', 'background-color: #483d8b'),
(36, 'darkslategray', '2f4f4f', 'DARKSLATEGRAY', 'background-color: #2f4f4f'),
(37, 'darkturquoise', '00ced1', 'DARKTURQUOISE', 'background-color: #00ced1'),
(38, 'darkviolet', '9400d3', 'DARKVIOLET', 'background-color: #9400d3'),
(39, 'deeppink', 'ff1493', 'DEEPPINK', 'background-color: #ff1493'),
(40, 'deepskyblue', '00bfff', 'DEEPSKYBLUE', 'background-color: #00bfff'),
(41, 'dimgray/grey', '696969', 'DIMGRAY/GREY', 'background-color: #696969'),
(42, 'dodgerblue', '1e90ff', 'DODGERBLUE', 'background-color: #1e90ff'),
(43, 'firebrick', 'b22222', 'FIREBRICK', 'background-color: #b22222'),
(44, 'floralwhite', 'fffaf0', 'FLORALWHITE', 'background-color: #fffaf0'),
(45, 'forestgreen', '228b22', 'FORESTGREEN', 'background-color: #228b22'),
(46, 'fuchsia', 'ff00ff', 'FUCHSIA', 'background-color: #ff00ff'),
(47, 'gainsboro', 'dcdcdc', 'GAINSBORO', 'background-color: #dcdcdc'),
(48, 'ghostwhite', 'f8f8ff', 'GHOSTWHITE', 'background-color: #f8f8ff'),
(49, 'gold', 'ffd700', 'GOLD', 'background-color: #ffd700'),
(50, 'goldenrod', 'daa520', 'GOLDENROD', 'background-color: #daa520'),
(51, 'gray', '808080', 'GRAY', 'background-color: #808080'),
(52, 'green', '008000', 'GREEN', 'background-color: #008000'),
(53, 'greenyellow', 'adff2f', 'GREENYELLOW', 'background-color: #adff2f'),
(54, 'honeydew', 'f0fff0', 'HONEYDEW', 'background-color: #f0fff0'),
(55, 'hotpink', 'ff69b4', 'HOTPINK', 'background-color: #ff69b4'),
(56, 'indianred', 'cd5c5c', 'INDIANRED', 'background-color: #cd5c5c'),
(57, 'indigo', '4b0082', 'INDIGO', 'background-color: #4b0082'),
(58, 'ivory', 'fffff0', 'IVORY', 'background-color: #fffff0'),
(59, 'khaki', 'f0e68c', 'KHAKI', 'background-color: #f0e68c'),
(60, 'lavender', 'e6e6fa', 'LAVENDER', 'background-color: #e6e6fa'),
(61, 'lavenderblush', 'fff0f5', 'LAVENDERBLUSH', 'background-color: #fff0f5'),
(62, 'lawngreen', '7cfc00', 'LAWNGREEN', 'background-color: #7cfc00'),
(63, 'lemonchiffon', 'fffacd', 'LEMONCHIFFON', 'background-color: #fffacd'),
(64, 'lightblue', 'add8e6', 'LIGHTBLUE', 'background-color: #add8e6'),
(65, 'lightcoral', 'f08080', 'LIGHTCORAL', 'background-color: #f08080'),
(66, 'lightcyan', 'e0ffff', 'LIGHTCYAN', 'background-color: #e0ffff'),
(67, 'lightgoldenrodyellow', 'fafad2', 'LIGHTGOLDENRODYELLOW', 'background-color: #fafad2'),
(68, 'lightgreen', '90ee90', 'LIGHTGREEN', 'background-color: #90ee90'),
(69, 'lightgray', 'd3d3d3', 'LIGHTGRAY', 'background-color: #d3d3d3'),
(70, 'lightpink', 'ffb6c1', 'LIGHTPINK', 'background-color: #ffb6c1'),
(71, 'lightsalmon', 'ffa07a', 'LIGHTSALMON', 'background-color: #ffa07a'),
(72, 'lightseagreen', '20b2aa', 'LIGHTSEAGREEN', 'background-color: #20b2aa'),
(73, 'lightskyblue', '87cefa', 'LIGHTSKYBLUE', 'background-color: #87cefa'),
(74, 'lightslategray', '778899', 'LIGHTSLATEGRAY', 'background-color: #778899'),
(75, 'lightsteelblue', 'b0c4de', 'LIGHTSTEELBLUE', 'background-color: #b0c4de'),
(76, 'lightyellow', 'ffffe0', 'LIGHTYELLOW', 'background-color: #ffffe0'),
(77, 'lime', '00ff00', 'LIME', 'background-color: #00ff00'),
(78, 'limegreen', '32cd32', 'LIMEGREEN', 'background-color: #32cd32'),
(79, 'linen', 'faf0e6', 'LINEN', 'background-color: #faf0e6'),
(80, 'magenta', 'ff00ff', 'MAGENTA', 'background-color: #ff00ff'),
(81, 'maroon', '800000', 'MAROON', 'background-color: #800000'),
(82, 'mediumaquamarine', '66cdaa', 'MEDIUMAQUAMARINE', 'background-color: #66cdaa'),
(83, 'mediumblue', '0000cd', 'MEDIUMBLUE', 'background-color: #0000cd'),
(84, 'mediumorchid', 'ba55d3', 'MEDIUMORCHID', 'background-color: #ba55d3'),
(85, 'mediumpurple', '9370db', 'MEDIUMPURPLE', 'background-color: #9370db'),
(86, 'mediumseagreen', '3cb371', 'MEDIUMSEAGREEN', 'background-color: #3cb371'),
(87, 'mediumslateblue', '7b68ee', 'MEDIUMSLATEBLUE', 'background-color: #7b68ee'),
(88, 'mediumspringgreen', '00fa9a', 'MEDIUMSPRINGGREEN', 'background-color: #00fa9a'),
(89, 'mediumturquoise', '48d1cc', 'MEDIUMTURQUOISE', 'background-color: #48d1cc'),
(90, 'mediumvioletred', 'c71585', 'MEDIUMVIOLETRED', 'background-color: #c71585'),
(91, 'midnightblue', '191970', 'MIDNIGHTBLUE', 'background-color: #191970'),
(92, 'mintcream', 'f5fffa', 'MINTCREAM', 'background-color: #f5fffa'),
(93, 'mistyrose', 'ffe4e1', 'MISTYROSE', 'background-color: #ffe4e1'),
(94, 'moccasin', 'ffe4b5', 'MOCCASIN', 'background-color: #ffe4b5'),
(95, 'navajowhite', 'ffdead', 'NAVAJOWHITE', 'background-color: #ffdead'),
(96, 'navy', '000080', 'NAVY', 'background-color: #000080'),
(97, 'oldlace', 'fdf5e6', 'OLDLACE', 'background-color: #fdf5e6'),
(98, 'olive', '808000', 'OLIVE', 'background-color: #808000'),
(99, 'olivedrab', '6b8e23', 'OLIVEDRAB', 'background-color: #6b8e23'),
(100, 'orange', 'ffa500', 'ORANGE', 'background-color: #ffa500'),
(101, 'orangered', 'ff4500', 'ORANGERED', 'background-color: #ff4500'),
(102, 'orchid', 'da70d6', 'ORCHID', 'background-color: #da70d6'),
(103, 'palegoldenrod', 'eee8aa', 'PALEGOLDENROD', 'background-color: #eee8aa'),
(104, 'palegreen', '98fb98', 'PALEGREEN', 'background-color: #98fb98'),
(105, 'paleturquoise', 'afeeee', 'PALETURQUOISE', 'background-color: #afeeee'),
(106, 'palevioletred', 'db7093', 'PALEVIOLETRED', 'background-color: #db7093'),
(107, 'papayawhip', 'ffefd5', 'PAPAYAWHIP', 'background-color: #ffefd5'),
(108, 'peachpuff', 'ffdab9', 'PEACHPUFF', 'background-color: #ffdab9'),
(109, 'peru', 'cd853f', 'PERU', 'background-color: #cd853f'),
(110, 'pink', 'ffc0cb', 'PINK', 'background-color: #ffc0cb'),
(111, 'plum', 'dda0dd', 'PLUM', 'background-color: #dda0dd'),
(112, 'powderblue', 'b0e0e6', 'POWDERBLUE', 'background-color: #b0e0e6'),
(113, 'purple', '800080', 'PURPLE', 'background-color: #800080'),
(114, 'red', 'ff0000', 'RED', 'background-color: #ff0000'),
(115, 'rosybrown', 'bc8f8f', 'ROSYBROWN', 'background-color: #bc8f8f'),
(116, 'royalblue', '4169e1', 'ROYALBLUE', 'background-color: #4169e1'),
(117, 'saddlebrown', '8b4513', 'SADDLEBROWN', 'background-color: #8b4513'),
(118, 'salmon', 'fa8072', 'SALMON', 'background-color: #fa8072'),
(119, 'sandybrown', 'f4a460', 'SANDYBROWN', 'background-color: #f4a460'),
(120, 'seagreen', '2e8b57', 'SEAGREEN', 'background-color: #2e8b57'),
(121, 'seashell', 'fff5ee', 'SEASHELL', 'background-color: #fff5ee'),
(122, 'sienna', 'a0522d', 'SIENNA', 'background-color: #a0522d'),
(123, 'silver', 'c0c0c0', 'SILVER', 'background-color: #c0c0c0'),
(124, 'skyblue', '87ceeb', 'SKYBLUE', 'background-color: #87ceeb'),
(125, 'slateblue', '6a5acd', 'SLATEBLUE', 'background-color: #6a5acd'),
(126, 'slategray', '708090', 'SLATEGRAY', 'background-color: #708090'),
(127, 'snow', 'fffafa', 'SNOW', 'background-color: #fffafa'),
(128, 'springgreen', '00ff7f', 'SPRINGGREEN', 'background-color: #00ff7f'),
(129, 'steelblue', '4682b4', 'STEELBLUE', 'background-color: #4682b4'),
(130, 'tan', 'd2b48c', 'TAN', 'background-color: #d2b48c'),
(131, 'teal', '008080', 'TEAL', 'background-color: #008080'),
(132, 'thistle', 'd8bfd8', 'THISTLE', 'background-color: #d8bfd8'),
(133, 'tomato', 'ff6347', 'TOMATO', 'background-color: #ff6347'),
(134, 'turquoise', '40e0d0', 'TURQUOISE', 'background-color: #40e0d0'),
(135, 'violet', 'ee82ee', 'VIOLET', 'background-color: #ee82ee'),
(136, 'wheat', 'f5deb3', 'WHEAT', 'background-color: #f5deb3'),
(137, 'white', 'ffffff', 'WHITE', 'background-color: #ffffff'),
(138, 'whitesmoke', 'f5f5f5', 'WHITESMOKE', 'background-color: #f5f5f5'),
(139, 'yellow', 'ffff00', 'YELLOW', 'background-color: #ffff00'),
(140, 'yellowgreen', '9acd32', 'YELLOWGREEN', 'background-color: #9acd32'),
(141, 'darkredsardonyx', '7a0323', 'DARKREDSARDONYX', 'background-color: #7a0223'),
(142, 'lightredsardonyx', 'a80533', 'LIGHTREDSARDONYX', 'background-color: #a80533'),
(143, 'bluesapphire', '111dc1', 'BLUESAPPHIRE', 'background-color: #111dc1'),
(144, 'darkbluesapphire', '020344', 'DARKBLUESAPPHIRE', 'background-color: #020344'),
(145, 'darkberyl', '10482d', 'DARKBERYL', 'background-color: #10482d'),
(146, 'lightberyl', '60d89a', 'LIGHTBERYL', 'background-color: #60d89a'),
(147, 'darkamethyst', '1c0031', 'DARKAMETHYST', 'background-color: #1c0031'),
(148, 'lightamethyst', 'a244b2', 'LIGHTAMETHYST', 'background-color: #a244b2');

-- --------------------------------------------------------

--
-- Structure of table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `co_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `writer` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `status` smallint(6) unsigned NOT NULL DEFAULT '5',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `group_id` bigint(20) NOT NULL DEFAULT '0',
  `level` int(11) NOT NULL DEFAULT '0',
  `sequence` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`co_id`),
  KEY `post_id` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure of table `commentmeta`
--

CREATE TABLE IF NOT EXISTS `commentmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` bigint(20) unsigned NOT NULL,
  `meta_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`meta_id`),
  UNIQUE KEY `comment_id` (`comment_id`,`meta_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure of table `link`
--

CREATE TABLE IF NOT EXISTS `link` (
  `link_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT '''''',
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT '''''',
  `link_type` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `target` varchar(30) COLLATE utf8_unicode_ci DEFAULT '''''',
  `description` text COLLATE utf8_unicode_ci,
  `visible` varchar(20) COLLATE utf8_unicode_ci DEFAULT '''''',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `rel` varchar(255) COLLATE utf8_unicode_ci DEFAULT '''''',
  `notes` mediumtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`link_id`),
  KEY `owner_id` (`owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure of table `media`
--

CREATE TABLE IF NOT EXISTS `media` (
  `media_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) DEFAULT NULL,
  `display_filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `caption` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_size` bigint(20) unsigned NOT NULL DEFAULT '0',
  `file_type` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_mime_type` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumb_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumb_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumb_width` int(11) DEFAULT NULL,
  `thumb_height` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `description` text CHARACTER SET utf8,
  PRIMARY KEY (`media_id`),
  KEY `owner_id` (`owner_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=171 ;

--
-- Structure of table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_label` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `menu_link` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `menu_active` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `owner_id` int(11) NOT NULL,
  `menu_layout` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'admin',
  `menu_params` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `menu_order` int(11) NOT NULL DEFAULT '0',
  `parent` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`menu_id`),
  KEY `owner_id` (`owner_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Structure of table `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump data of table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m150610_162817_oauth', 1517915548);

-- --------------------------------------------------------

--
-- Structure of table `oauth2_access_token`
--

CREATE TABLE IF NOT EXISTS `oauth2_access_token` (
  `access_token` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `client_id` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `expires` int(11) NOT NULL,
  `scope` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`access_token`),
  KEY `fk_access_token_oauth2_client_client_id` (`client_id`),
  KEY `ix_access_token_expires` (`expires`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure of table `oauth2_authorization_code`
--

CREATE TABLE IF NOT EXISTS `oauth2_authorization_code` (
  `authorization_code` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `client_id` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `redirect_uri` text COLLATE utf8_unicode_ci NOT NULL,
  `expires` int(11) NOT NULL,
  `scope` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`authorization_code`),
  KEY `fk_authorization_code_oauth2_client_client_id` (`client_id`),
  KEY `ix_authorization_code_expires` (`expires`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure of table `oauth2_client`
--

CREATE TABLE IF NOT EXISTS `oauth2_client` (
  `client_id` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `client_secret` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `redirect_uri` text COLLATE utf8_unicode_ci NOT NULL,
  `grant_type` text COLLATE utf8_unicode_ci,
  `scope` text COLLATE utf8_unicode_ci,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure of table `oauth2_refresh_token`
--

CREATE TABLE IF NOT EXISTS `oauth2_refresh_token` (
  `refresh_token` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `client_id` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `expires` int(11) NOT NULL,
  `scope` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`refresh_token`),
  KEY `fk_refresh_token_oauth2_client_client_id` (`client_id`),
  KEY `ix_refresh_token_expires` (`expires`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure of table `option`
--

CREATE TABLE IF NOT EXISTS `option` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT '''''',
  `value` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Structure of table `popup`
--

CREATE TABLE IF NOT EXISTS `popup` (
  `popup_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `dim_x` int(11) DEFAULT NULL,
  `dim_y` int(11) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `popup_type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `po_option` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `po_center` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `pages` text COLLATE utf8_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`popup_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Structure of table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `po_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `author_id` int(11) DEFAULT NULL,
  `parent` bigint(20) unsigned zerofill NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `writer` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '''''',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci,
  `excerpt` text COLLATE utf8_unicode_ci,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `homepage` varchar(255) COLLATE utf8_unicode_ci DEFAULT '''''',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `term_taxonomy_id` int(11) unsigned zerofill NOT NULL,
  `status` smallint(6) unsigned DEFAULT '0',
  `tags` tinytext COLLATE utf8_unicode_ci,
  `post_type` varchar(30) COLLATE utf8_unicode_ci DEFAULT 'post',
  `group_id` bigint(20) NOT NULL DEFAULT '0',
  `level` int(11) NOT NULL DEFAULT '0',
  `sequence` int(11) NOT NULL DEFAULT '0',
  `hit_count` int(11) DEFAULT '0',
  `comment_status` varchar(10) COLLATE utf8_unicode_ci DEFAULT 'close',
  `comment_count` int(11) DEFAULT '0',
  PRIMARY KEY (`po_id`),
  KEY `author_id` (`author_id`),
  KEY `term_taxonomy_id` (`term_taxonomy_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=61 ;


--
-- Structure of table `postmeta`
--

CREATE TABLE IF NOT EXISTS `postmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL,
  `meta_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`meta_id`),
  UNIQUE KEY `post_id` (`post_id`,`meta_key`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=57 ;

--
-- Structure of table `term`
--

CREATE TABLE IF NOT EXISTS `term` (
  `term_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `slug` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `term_order` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;


--
-- Structure of table `termmeta`
--

CREATE TABLE IF NOT EXISTS `termmeta` (
  `meta_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` int(11) unsigned NOT NULL,
  `meta_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`meta_id`),
  UNIQUE KEY `term_id` (`term_id`,`meta_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure of table `term_taxonomy`
--

CREATE TABLE IF NOT EXISTS `term_taxonomy` (
  `term_taxonomy_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` int(11) unsigned NOT NULL,
  `taxonomy` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `parent` int(11) unsigned NOT NULL DEFAULT '0',
  `family_id` bigint(20) unsigned NOT NULL,
  `level` int(11) NOT NULL DEFAULT '0',
  `sequence` int(11) NOT NULL DEFAULT '0',
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  `color` varchar(60) COLLATE utf8_unicode_ci DEFAULT 'darkredsardonyx',
  `color2` varchar(60) COLLATE utf8_unicode_ci DEFAULT 'lightredsardonyx',
  `font` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `write_level` varchar(64) COLLATE utf8_unicode_ci DEFAULT 'author',
  `update_level` varchar(64) COLLATE utf8_unicode_ci DEFAULT 'author',
  `view_level` varchar(64) COLLATE utf8_unicode_ci DEFAULT 'author',
  `list_level` varchar(64) COLLATE utf8_unicode_ci DEFAULT 'author',
  `reply_level` varchar(64) COLLATE utf8_unicode_ci DEFAULT 'author',
  PRIMARY KEY (`term_taxonomy_id`),
  UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`) USING BTREE,
  KEY `taxonomy` (`taxonomy`),
  KEY `fk2_taxonomy_taxonomy` (`parent`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

--
-- Structure of table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nickname` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `user_icon` bigint(20) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Structure of table `usermeta`
--

CREATE TABLE IF NOT EXISTS `usermeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `meta_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_value` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`meta_id`),
  UNIQUE KEY `user_id` (`user_id`,`meta_key`),
  KEY `user_id_2` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Structure of table `websight_log`
--

CREATE TABLE IF NOT EXISTS `websight_log` (
  `idx` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT '0',
  `browser` int(11) unsigned NOT NULL,
  `domain` int(11) unsigned NOT NULL,
  `referer` int(11) unsigned NOT NULL,
  `ip` int(11) unsigned NOT NULL,
  `searchengin` int(11) unsigned NOT NULL,
  `keyword` int(11) unsigned NOT NULL,
  `os` int(11) unsigned NOT NULL,
  `page` int(11) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idx`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=176715 ;

--
-- Structure of table `websight_log_browser`
--

CREATE TABLE IF NOT EXISTS `websight_log_browser` (
  `idx` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `browser` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hit` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idx`),
  KEY `browser` (`browser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=41 ;

--
-- Structure of table `websight_log_counter`
--

CREATE TABLE IF NOT EXISTS `websight_log_counter` (
  `idx` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `yyyy` char(4) COLLATE utf8_unicode_ci NOT NULL,
  `mm` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `dd` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `h0` int(11) DEFAULT '0',
  `h1` int(11) DEFAULT '0',
  `h2` int(11) DEFAULT '0',
  `h3` int(11) DEFAULT '0',
  `h4` int(11) DEFAULT '0',
  `h5` int(11) DEFAULT '0',
  `h6` int(11) DEFAULT '0',
  `h7` int(11) DEFAULT '0',
  `h8` int(11) DEFAULT '0',
  `h9` int(11) DEFAULT '0',
  `h10` int(11) DEFAULT '0',
  `h11` int(11) DEFAULT '0',
  `h12` int(11) DEFAULT '0',
  `h13` int(11) DEFAULT '0',
  `h14` int(11) DEFAULT '0',
  `h15` int(11) DEFAULT '0',
  `h16` int(11) DEFAULT '0',
  `h17` int(11) DEFAULT '0',
  `h18` int(11) DEFAULT '0',
  `h19` int(11) DEFAULT '0',
  `h20` int(11) DEFAULT '0',
  `h21` int(11) DEFAULT '0',
  `h22` int(11) DEFAULT '0',
  `h23` int(11) DEFAULT '0',
  `week` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `hit` int(11) DEFAULT '0',
  PRIMARY KEY (`idx`),
  UNIQUE KEY `yyyy` (`yyyy`,`mm`,`dd`),
  KEY `yyyy_2` (`yyyy`),
  KEY `mm` (`mm`,`dd`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=251 ;

--
-- Structure of table `websight_log_domain`
--

CREATE TABLE IF NOT EXISTS `websight_log_domain` (
  `idx` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `domain` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hit` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idx`),
  KEY `domain` (`domain`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=74 ;

--
-- Structure of table `websight_log_ip`
--

CREATE TABLE IF NOT EXISTS `websight_log_ip` (
  `idx` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hit` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idx`),
  KEY `ip` (`ip`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=55848 ;

--
-- Structure of table `websight_log_keyword`
--

CREATE TABLE IF NOT EXISTS `websight_log_keyword` (
  `idx` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `keyword` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hit` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idx`),
  KEY `keyword` (`keyword`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Structure of table `websight_log_os`
--

CREATE TABLE IF NOT EXISTS `websight_log_os` (
  `idx` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `os` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hit` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idx`),
  KEY `os` (`os`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Structure of table `websight_log_page`
--

CREATE TABLE IF NOT EXISTS `websight_log_page` (
  `idx` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `page` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hit` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idx`),
  KEY `page` (`page`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4557 ;

--
-- Structure of table `websight_log_searchengin`
--

CREATE TABLE IF NOT EXISTS `websight_log_searchengin` (
  `idx` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `searchengin` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hit` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idx`),
  KEY `searchengin` (`searchengin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `post_fk` FOREIGN KEY (`post_id`) REFERENCES `post` (`po_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `commentmeta`
--
ALTER TABLE `commentmeta`
  ADD CONSTRAINT `comment_fk` FOREIGN KEY (`comment_id`) REFERENCES `comment` (`co_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `link`
--
ALTER TABLE `link`
  ADD CONSTRAINT `link_owner_fk` FOREIGN KEY (`owner_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `media_owner_fk` FOREIGN KEY (`owner_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `fk_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `oauth2_access_token`
--
ALTER TABLE `oauth2_access_token`
  ADD CONSTRAINT `fk_access_token_oauth2_client_client_id` FOREIGN KEY (`client_id`) REFERENCES `oauth2_client` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `oauth2_authorization_code`
--
ALTER TABLE `oauth2_authorization_code`
  ADD CONSTRAINT `fk_authorization_code_oauth2_client_client_id` FOREIGN KEY (`client_id`) REFERENCES `oauth2_client` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `oauth2_refresh_token`
--
ALTER TABLE `oauth2_refresh_token`
  ADD CONSTRAINT `fk_refresh_token_oauth2_client_client_id` FOREIGN KEY (`client_id`) REFERENCES `oauth2_client` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_author_fk` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_taxonomy_fk` FOREIGN KEY (`term_taxonomy_id`) REFERENCES `term_taxonomy` (`term_taxonomy_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `postmeta`
--
ALTER TABLE `postmeta`
  ADD CONSTRAINT `post_comment_fk` FOREIGN KEY (`post_id`) REFERENCES `post` (`po_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `termmeta`
--
ALTER TABLE `termmeta`
  ADD CONSTRAINT `term_fk` FOREIGN KEY (`term_id`) REFERENCES `term` (`term_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `term_taxonomy`
--
ALTER TABLE `term_taxonomy`
  ADD CONSTRAINT `fk2_taxonomy_taxonomy` FOREIGN KEY (`parent`) REFERENCES `term_taxonomy` (`term_taxonomy_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `taxonomy_term_fk` FOREIGN KEY (`term_id`) REFERENCES `term` (`term_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `usermeta`
--
ALTER TABLE `usermeta`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

