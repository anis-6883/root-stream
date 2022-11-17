DROP TABLE IF EXISTS app_contents;

CREATE TABLE `app_contents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `app_id` bigint(20) unsigned NOT NULL,
  `platform` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO app_contents VALUES('1','6','android','android_app_publishing_control','off','2022-11-16 07:15:08','2022-11-16 07:15:15');
INSERT INTO app_contents VALUES('2','6','android','android_live_version_code','3','2022-11-16 07:15:08','2022-11-16 07:15:15');
INSERT INTO app_contents VALUES('3','6','android','android_privacy_policy','Hmm','2022-11-16 07:32:09','2022-11-16 07:32:16');
INSERT INTO app_contents VALUES('4','6','android','android_terms_and_condition','Hmm','2022-11-16 07:32:09','2022-11-16 07:32:17');
INSERT INTO app_contents VALUES('5','6','android','android_app_share_link','http://localhost/rootstream/manage_app/1667903711_1688115489','2022-11-16 07:32:09','2022-11-16 07:32:17');
INSERT INTO app_contents VALUES('6','6','android','android_default_page','2','2022-11-16 07:32:09','2022-11-16 07:32:17');
INSERT INTO app_contents VALUES('7','2','android','android_ads_type','facebook','2022-11-16 07:32:36','2022-11-16 07:32:36');
INSERT INTO app_contents VALUES('8','2','android','android_click_control','3','2022-11-16 07:32:36','2022-11-16 07:32:36');
INSERT INTO app_contents VALUES('9','2','android','android_version_name','1.0.0','2022-11-16 07:34:37','2022-11-16 07:34:37');
INSERT INTO app_contents VALUES('10','2','android','android_version_code','1','2022-11-16 07:34:38','2022-11-16 07:34:38');
INSERT INTO app_contents VALUES('11','2','android','android_force_update','no','2022-11-16 07:34:38','2022-11-16 07:34:38');
INSERT INTO app_contents VALUES('12','2','android','android_app_url','http://localhost/rootstream/manage_app/1667903711_1688115489','2022-11-16 07:34:38','2022-11-16 07:34:38');
INSERT INTO app_contents VALUES('13','2','android','android_button_text','ADD','2022-11-16 07:34:38','2022-11-16 07:34:38');



DROP TABLE IF EXISTS apps;

CREATE TABLE `apps` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `app_unique_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_logo_type` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_logo_url` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `app_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notification_type` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `onesignal_app_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `onesignal_api_key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firebase_server_key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firebase_topics` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `support_mail` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_mail` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_host` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_port` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_encryption` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `apps_app_unique_id_unique` (`app_unique_id`),
  UNIQUE KEY `apps_app_name_unique` (`app_name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO apps VALUES('2','1667903711_1688115488','PrimeGoal','image','','public/uploads/images/apps/APP_1769533874_63731cfa1034a.png','fcm','','','12345','PrimeGoal','test@email.com','test@email.com','qwqqw','wqwqw','1111','2232','121212','tls','1','2022-11-08 10:36:19','2022-11-15 05:00:42');
INSERT INTO apps VALUES('6','1667903711_1688115489','HesGoal','image','','public/uploads/images/apps/APP_1358881206_637479182894d.png','fcm','','','AAAAGSiLaP8:APA91bFXykNo_WALujlijzUZg9Zy1RDK7BbFQeWMCoumedslElDKb2FhfiYT7EZNOXbzgLF414vsxNYpzZ7ml2gI3___qPk22nB9Zqr2tQ8w6uB5ToIlPl_CszHiwr0e6Lb3pxyXgiD4','hotserial','test@email.com','test@email.com','qwqqw','wqwqw','1111','2232','121212','tls','1','2022-11-08 10:36:19','2022-11-16 12:44:12');



DROP TABLE IF EXISTS failed_jobs;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS highlight_apps;

CREATE TABLE `highlight_apps` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `app_id` bigint(20) unsigned NOT NULL,
  `highlight_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO highlight_apps VALUES('2','2','1','2022-11-15 07:05:27','2022-11-15 07:05:27');



DROP TABLE IF EXISTS highlight_streaming_sources;

CREATE TABLE `highlight_streaming_sources` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `highlight_id` bigint(20) unsigned NOT NULL,
  `stream_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stream_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resulation` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stream_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stream_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `block_country` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_block_them` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO highlight_streaming_sources VALUES('3','1','Link 1','restricted','1080p','http://localhost/rootstream/highlights/create','','{\"Content-Type\":\"application\\/json; charset=UTF-8\"}','Egypt,Pakistan','1','2022-11-15 07:05:27','2022-11-15 07:05:27');
INSERT INTO highlight_streaming_sources VALUES('4','1','Link 2','root_stream','1080p','http://localhost/rootstream/highlights/create','12345','','American Samoa','1','2022-11-15 07:05:27','2022-11-15 07:05:27');
INSERT INTO highlight_streaming_sources VALUES('5','1','Link 3','web','360p','https://images.unsplash.com/photo-1665686376173-ada7a0031a85?ixlib=rb-4.0.3&ixid=MnwxMjA3fDF8MHxlZGl0b3JpYWwtZmVlZHw2fHx8ZW58MHx8fHw%3D&auto=format&fit=crop&w=500&q=60','','','Bangladesh','1','2022-11-15 07:05:27','2022-11-15 07:05:27');



DROP TABLE IF EXISTS highlights;

CREATE TABLE `highlights` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sports_type_id` bigint(20) unsigned NOT NULL,
  `match_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover_image_type` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover_url` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `team_one_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `team_one_image_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `team_one_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `team_one_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `team_two_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `team_two_image_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `team_two_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `team_two_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO highlights VALUES('1','2','FIFA','image','','public/uploads/images/highlights/COVER_1345462776.63733841c4da6.png','Pakistan','url','https://images.unsplash.com/photo-1659536009108-ebe9053222d4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDF8MHxlZGl0b3JpYWwtZmVlZHwxfHx8ZW58MHx8fHw%3D&auto=format&fit=crop&w=500&q=60','','England','url','https://images.unsplash.com/photo-1665686376173-ada7a0031a85?ixlib=rb-4.0.3&ixid=MnwxMjA3fDF8MHxlZGl0b3JpYWwtZmVlZHw2fHx8ZW58MHx8fHw%3D&auto=format&fit=crop&w=500&q=60','','1','2022-11-15 06:57:05','2022-11-15 07:05:27');



DROP TABLE IF EXISTS live_match_apps;

CREATE TABLE `live_match_apps` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `app_id` bigint(20) unsigned NOT NULL,
  `match_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO live_match_apps VALUES('16','6','2','2022-11-15 04:58:46','2022-11-15 04:58:46');



DROP TABLE IF EXISTS live_matches;

CREATE TABLE `live_matches` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sports_type_id` bigint(20) unsigned NOT NULL,
  `match_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `match_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover_image_type` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover_url` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `team_one_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `team_one_image_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `team_one_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `team_one_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `team_two_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `team_two_image_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `team_two_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `team_two_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` bigint(20) NOT NULL DEFAULT 99999999999,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO live_matches VALUES('2','1','1669824000','Final Match ICC 2022','image','https://images.unsplash.com/photo-1667845217693-e9ddba94a13a?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw2NHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=60','public/uploads/images/live_matches/COVER_1596101661.636e8f9c7dc1b.jpg','Team ABC','url','https://images.unsplash.com/photo-1667845217693-e9ddba94a13a?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw2NHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=60','','Team DEF','image','','public/uploads/images/live_matches/TEAM_1817431465.636e808616231.png','99999999999','1','2022-11-11 17:04:06','2022-11-11 18:08:28');



DROP TABLE IF EXISTS migrations;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO migrations VALUES('2','2014_10_12_100000_create_password_resets_table','1');
INSERT INTO migrations VALUES('3','2019_08_19_000000_create_failed_jobs_table','1');
INSERT INTO migrations VALUES('4','2019_12_14_000001_create_personal_access_tokens_table','1');
INSERT INTO migrations VALUES('5','2022_09_05_115648_create_settings_table','1');
INSERT INTO migrations VALUES('7','2022_11_07_091453_create_permission_tables','2');
INSERT INTO migrations VALUES('8','2014_10_12_000000_create_users_table','3');
INSERT INTO migrations VALUES('9','2022_11_08_090706_create_apps_table','4');
INSERT INTO migrations VALUES('11','2022_11_08_143010_create_sports_types_table','5');
INSERT INTO migrations VALUES('16','2022_11_10_063759_create_live_matches_table','6');
INSERT INTO migrations VALUES('17','2022_11_10_064021_create_live_match_apps_table','6');
INSERT INTO migrations VALUES('18','2022_11_10_064108_create_streaming_sources_table','6');
INSERT INTO migrations VALUES('19','2022_11_15_052922_create_popular_series_table','7');
INSERT INTO migrations VALUES('20','2022_11_15_062403_create_highlights_table','8');
INSERT INTO migrations VALUES('21','2022_11_15_062424_create_highlight_apps_table','8');
INSERT INTO migrations VALUES('22','2022_11_15_062503_create_highlight_streaming_sources_table','8');
INSERT INTO migrations VALUES('25','2022_11_16_055756_create_app_contents_table','9');
INSERT INTO migrations VALUES('26','2022_11_16_104311_create_notifications_table','10');
INSERT INTO migrations VALUES('27','2022_11_16_140307_create_subscriptions_table','11');
INSERT INTO migrations VALUES('31','2022_11_17_065543_create_payments_table','12');



DROP TABLE IF EXISTS model_has_permissions;

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO model_has_permissions VALUES('41','App\\Models\\User','1');
INSERT INTO model_has_permissions VALUES('42','App\\Models\\User','1');
INSERT INTO model_has_permissions VALUES('43','App\\Models\\User','1');
INSERT INTO model_has_permissions VALUES('44','App\\Models\\User','1');
INSERT INTO model_has_permissions VALUES('45','App\\Models\\User','1');
INSERT INTO model_has_permissions VALUES('46','App\\Models\\User','1');
INSERT INTO model_has_permissions VALUES('47','App\\Models\\User','1');
INSERT INTO model_has_permissions VALUES('48','App\\Models\\User','1');
INSERT INTO model_has_permissions VALUES('49','App\\Models\\User','1');
INSERT INTO model_has_permissions VALUES('50','App\\Models\\User','1');
INSERT INTO model_has_permissions VALUES('51','App\\Models\\User','1');
INSERT INTO model_has_permissions VALUES('52','App\\Models\\User','1');
INSERT INTO model_has_permissions VALUES('53','App\\Models\\User','1');
INSERT INTO model_has_permissions VALUES('54','App\\Models\\User','1');
INSERT INTO model_has_permissions VALUES('55','App\\Models\\User','1');
INSERT INTO model_has_permissions VALUES('56','App\\Models\\User','1');
INSERT INTO model_has_permissions VALUES('57','App\\Models\\User','1');
INSERT INTO model_has_permissions VALUES('58','App\\Models\\User','1');
INSERT INTO model_has_permissions VALUES('59','App\\Models\\User','1');
INSERT INTO model_has_permissions VALUES('60','App\\Models\\User','1');



DROP TABLE IF EXISTS model_has_roles;

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO model_has_roles VALUES('3','App\\Models\\User','1');
INSERT INTO model_has_roles VALUES('5','App\\Models\\User','1');



DROP TABLE IF EXISTS notifications;

CREATE TABLE `notifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `apps` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notification_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS password_resets;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS payments;

CREATE TABLE `payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `subscription_id` bigint(20) NOT NULL,
  `date` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `platform` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO payments VALUES('1','3','2','','500','ios','6','2022-11-17 13:38:04','');



DROP TABLE IF EXISTS permissions;

CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO permissions VALUES('41','permission.create','web','permission','2022-11-07 09:47:06','2022-11-07 09:47:06');
INSERT INTO permissions VALUES('42','permission.view','web','permission','2022-11-07 09:47:06','2022-11-07 09:47:06');
INSERT INTO permissions VALUES('43','permission.edit','web','permission','2022-11-07 09:47:06','2022-11-07 09:47:06');
INSERT INTO permissions VALUES('44','permission.delete','web','permission','2022-11-07 09:47:06','2022-11-07 09:47:06');
INSERT INTO permissions VALUES('45','permission.access','web','permission','2022-11-07 09:47:06','2022-11-07 09:47:06');
INSERT INTO permissions VALUES('46','role.create','web','role','2022-11-07 09:47:06','2022-11-07 09:47:06');
INSERT INTO permissions VALUES('47','role.view','web','role','2022-11-07 09:47:07','2022-11-07 09:47:07');
INSERT INTO permissions VALUES('48','role.edit','web','role','2022-11-07 09:47:07','2022-11-07 09:47:07');
INSERT INTO permissions VALUES('49','role.delete','web','role','2022-11-07 09:47:07','2022-11-07 09:47:07');
INSERT INTO permissions VALUES('50','role.access','web','role','2022-11-07 09:47:07','2022-11-07 09:47:07');
INSERT INTO permissions VALUES('51','app.create','web','app','2022-11-07 09:47:07','2022-11-07 09:47:07');
INSERT INTO permissions VALUES('52','app.view','web','app','2022-11-07 09:47:07','2022-11-07 09:47:07');
INSERT INTO permissions VALUES('53','app.edit','web','app','2022-11-07 09:47:07','2022-11-07 09:47:07');
INSERT INTO permissions VALUES('54','app.delete','web','app','2022-11-07 09:47:07','2022-11-07 09:47:07');
INSERT INTO permissions VALUES('55','app.access','web','app','2022-11-07 09:47:07','2022-11-07 09:47:07');
INSERT INTO permissions VALUES('56','live_match.create','web','live_match','2022-11-07 09:47:07','2022-11-07 09:47:07');
INSERT INTO permissions VALUES('57','live_match.view','web','live_match','2022-11-07 09:47:07','2022-11-07 09:47:07');
INSERT INTO permissions VALUES('58','live_match.edit','web','live_match','2022-11-07 09:47:07','2022-11-07 09:47:07');
INSERT INTO permissions VALUES('59','live_match.delete','web','live_match','2022-11-07 09:47:07','2022-11-07 09:47:07');
INSERT INTO permissions VALUES('60','live_match.access','web','live_match','2022-11-07 09:47:07','2022-11-07 09:47:07');
INSERT INTO permissions VALUES('65','admin.access','web','admin','2022-11-08 06:15:21','2022-11-08 06:15:21');
INSERT INTO permissions VALUES('66','admin.create','web','admin','2022-11-08 06:15:54','2022-11-08 06:15:54');
INSERT INTO permissions VALUES('67','admin.view','web','admin','2022-11-08 06:16:06','2022-11-08 06:16:06');
INSERT INTO permissions VALUES('68','admin.edit','web','admin','2022-11-08 06:16:12','2022-11-08 06:16:12');
INSERT INTO permissions VALUES('69','admin.delete','web','admin','2022-11-08 06:16:19','2022-11-08 06:16:19');
INSERT INTO permissions VALUES('70','sports_type.access','web','sports_type','2022-11-08 14:36:34','2022-11-08 14:36:34');
INSERT INTO permissions VALUES('71','sports_type.view','web','sports_type','2022-11-08 14:36:45','2022-11-08 14:36:45');
INSERT INTO permissions VALUES('72','sports_type.create','web','sports_type','2022-11-08 14:37:45','2022-11-08 14:37:45');
INSERT INTO permissions VALUES('73','sports_type.edit','web','sports_type','2022-11-08 14:37:57','2022-11-08 14:37:57');
INSERT INTO permissions VALUES('74','sports_type.delete','web','sports_type','2022-11-08 14:38:05','2022-11-08 14:38:05');
INSERT INTO permissions VALUES('75','popular_series.access','web','Popular Series','2022-11-15 05:42:58','2022-11-15 05:42:58');
INSERT INTO permissions VALUES('76','popular_series.create','web','Popular Series','2022-11-15 05:43:10','2022-11-15 05:43:10');
INSERT INTO permissions VALUES('77','popular_series.view','web','Popular Series','2022-11-15 05:43:28','2022-11-15 05:43:28');
INSERT INTO permissions VALUES('78','popular_series.edit','web','Popular Series','2022-11-15 05:43:41','2022-11-15 05:43:41');
INSERT INTO permissions VALUES('79','popular_series.delete','web','Popular Series','2022-11-15 05:43:51','2022-11-15 05:43:51');
INSERT INTO permissions VALUES('80','highlight.access','web','Highlight','2022-11-15 06:29:59','2022-11-15 06:29:59');
INSERT INTO permissions VALUES('81','highlight.create','web','Highlight','2022-11-15 06:30:09','2022-11-15 06:30:09');
INSERT INTO permissions VALUES('82','highlight.edit','web','Highlight','2022-11-15 06:30:18','2022-11-15 06:30:18');
INSERT INTO permissions VALUES('83','highlight.view','web','Highlight','2022-11-15 06:30:32','2022-11-15 06:30:32');
INSERT INTO permissions VALUES('84','highlight.delete','web','Highlight','2022-11-15 06:30:44','2022-11-15 06:30:44');
INSERT INTO permissions VALUES('90','notification.access','web','Notification','2022-11-16 10:52:59','2022-11-16 10:52:59');
INSERT INTO permissions VALUES('91','notification.view','web','Notification','2022-11-16 10:53:09','2022-11-16 10:53:09');
INSERT INTO permissions VALUES('92','notification.create','web','Notification','2022-11-16 10:53:20','2022-11-16 10:53:20');
INSERT INTO permissions VALUES('93','notification.edit','web','Notification','2022-11-16 10:53:28','2022-11-16 10:53:28');
INSERT INTO permissions VALUES('94','notification.delete','web','Notification','2022-11-16 10:53:37','2022-11-16 10:53:37');
INSERT INTO permissions VALUES('95','subscription.access','web','Subscription','2022-11-16 14:12:02','2022-11-16 14:12:02');
INSERT INTO permissions VALUES('96','subscription.view','web','Subscription','2022-11-16 14:12:15','2022-11-16 14:12:15');
INSERT INTO permissions VALUES('97','subscription.create','web','Subscription','2022-11-16 14:12:29','2022-11-16 14:12:29');
INSERT INTO permissions VALUES('98','subscription.edit','web','Subscription','2022-11-16 14:12:44','2022-11-16 14:12:44');
INSERT INTO permissions VALUES('99','subscription.delete','web','Subscription','2022-11-16 14:12:53','2022-11-16 14:12:53');
INSERT INTO permissions VALUES('100','user.access','web','User','2022-11-17 04:53:14','2022-11-17 04:53:14');
INSERT INTO permissions VALUES('101','user.view','web','User','2022-11-17 04:53:26','2022-11-17 04:53:26');
INSERT INTO permissions VALUES('102','user.create','web','User','2022-11-17 04:53:37','2022-11-17 04:53:37');
INSERT INTO permissions VALUES('103','user.edit','web','User','2022-11-17 04:53:44','2022-11-17 04:53:44');
INSERT INTO permissions VALUES('104','user.delete','web','User','2022-11-17 04:53:52','2022-11-17 04:53:52');
INSERT INTO permissions VALUES('105','payment.access','web','Payment','2022-11-17 07:06:16','2022-11-17 07:06:16');
INSERT INTO permissions VALUES('106','payment.view','web','Payment','2022-11-17 07:06:28','2022-11-17 07:06:28');
INSERT INTO permissions VALUES('107','administration.access','web','Administration','2022-11-17 09:02:37','2022-11-17 09:02:37');
INSERT INTO permissions VALUES('108','administration.view','web','Administration','2022-11-17 09:02:46','2022-11-17 09:02:46');
INSERT INTO permissions VALUES('109','administration.create','web','Administration','2022-11-17 09:03:03','2022-11-17 09:03:03');



DROP TABLE IF EXISTS personal_access_tokens;

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS popular_series;

CREATE TABLE `popular_series` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `apps` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO popular_series VALUES('1','[\"2\"]','Test Edit','Test Desc Edit','http://localhost/rootstream/popular_series/create/Edit','0','2022-11-15 06:05:10','2022-11-15 06:18:03');



DROP TABLE IF EXISTS role_has_permissions;

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO role_has_permissions VALUES('41','3');
INSERT INTO role_has_permissions VALUES('42','3');
INSERT INTO role_has_permissions VALUES('43','3');
INSERT INTO role_has_permissions VALUES('44','3');
INSERT INTO role_has_permissions VALUES('45','3');
INSERT INTO role_has_permissions VALUES('46','3');
INSERT INTO role_has_permissions VALUES('47','3');
INSERT INTO role_has_permissions VALUES('48','3');
INSERT INTO role_has_permissions VALUES('49','3');
INSERT INTO role_has_permissions VALUES('50','3');
INSERT INTO role_has_permissions VALUES('51','3');
INSERT INTO role_has_permissions VALUES('51','5');
INSERT INTO role_has_permissions VALUES('52','3');
INSERT INTO role_has_permissions VALUES('52','5');
INSERT INTO role_has_permissions VALUES('53','3');
INSERT INTO role_has_permissions VALUES('53','5');
INSERT INTO role_has_permissions VALUES('54','3');
INSERT INTO role_has_permissions VALUES('54','5');
INSERT INTO role_has_permissions VALUES('55','3');
INSERT INTO role_has_permissions VALUES('55','5');
INSERT INTO role_has_permissions VALUES('56','3');
INSERT INTO role_has_permissions VALUES('56','5');
INSERT INTO role_has_permissions VALUES('57','3');
INSERT INTO role_has_permissions VALUES('57','5');
INSERT INTO role_has_permissions VALUES('58','3');
INSERT INTO role_has_permissions VALUES('58','5');
INSERT INTO role_has_permissions VALUES('59','3');
INSERT INTO role_has_permissions VALUES('59','5');
INSERT INTO role_has_permissions VALUES('60','3');
INSERT INTO role_has_permissions VALUES('60','5');
INSERT INTO role_has_permissions VALUES('65','3');
INSERT INTO role_has_permissions VALUES('66','3');
INSERT INTO role_has_permissions VALUES('67','3');
INSERT INTO role_has_permissions VALUES('68','3');
INSERT INTO role_has_permissions VALUES('69','3');
INSERT INTO role_has_permissions VALUES('70','3');
INSERT INTO role_has_permissions VALUES('71','3');
INSERT INTO role_has_permissions VALUES('72','3');
INSERT INTO role_has_permissions VALUES('73','3');
INSERT INTO role_has_permissions VALUES('74','3');
INSERT INTO role_has_permissions VALUES('75','3');
INSERT INTO role_has_permissions VALUES('76','3');
INSERT INTO role_has_permissions VALUES('77','3');
INSERT INTO role_has_permissions VALUES('78','3');
INSERT INTO role_has_permissions VALUES('79','3');
INSERT INTO role_has_permissions VALUES('80','3');
INSERT INTO role_has_permissions VALUES('81','3');
INSERT INTO role_has_permissions VALUES('82','3');
INSERT INTO role_has_permissions VALUES('83','3');
INSERT INTO role_has_permissions VALUES('84','3');
INSERT INTO role_has_permissions VALUES('90','3');
INSERT INTO role_has_permissions VALUES('91','3');
INSERT INTO role_has_permissions VALUES('92','3');
INSERT INTO role_has_permissions VALUES('93','3');
INSERT INTO role_has_permissions VALUES('94','3');
INSERT INTO role_has_permissions VALUES('95','3');
INSERT INTO role_has_permissions VALUES('96','3');
INSERT INTO role_has_permissions VALUES('97','3');
INSERT INTO role_has_permissions VALUES('98','3');
INSERT INTO role_has_permissions VALUES('99','3');
INSERT INTO role_has_permissions VALUES('100','3');
INSERT INTO role_has_permissions VALUES('101','3');
INSERT INTO role_has_permissions VALUES('102','3');
INSERT INTO role_has_permissions VALUES('103','3');
INSERT INTO role_has_permissions VALUES('104','3');
INSERT INTO role_has_permissions VALUES('105','3');
INSERT INTO role_has_permissions VALUES('106','3');
INSERT INTO role_has_permissions VALUES('107','3');
INSERT INTO role_has_permissions VALUES('108','3');
INSERT INTO role_has_permissions VALUES('109','3');



DROP TABLE IF EXISTS roles;

CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO roles VALUES('3','Admin','web','2022-11-07 09:47:06','2022-11-07 09:47:06');
INSERT INTO roles VALUES('5','Manager','web','2022-11-07 17:31:49','2022-11-07 17:31:49');



DROP TABLE IF EXISTS settings;

CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO settings VALUES('1','company_name','Root Devs','2022-11-07 05:05:37','2022-11-17 09:28:45');
INSERT INTO settings VALUES('2','site_title','RootStream','2022-11-07 05:05:37','2022-11-17 09:28:45');
INSERT INTO settings VALUES('3','timezone','Asia/Dhaka','2022-11-07 05:05:37','2022-11-17 09:28:45');
INSERT INTO settings VALUES('4','language','English','2022-11-07 05:05:37','2022-11-17 09:28:45');
INSERT INTO settings VALUES('5','android_version_code','1','2022-11-07 05:05:37','2022-11-07 05:05:37');
INSERT INTO settings VALUES('6','ios_version_code','1','2022-11-07 05:05:37','2022-11-07 05:05:37');
INSERT INTO settings VALUES('7','android_live_control','off','2022-11-07 05:05:37','2022-11-07 05:05:37');
INSERT INTO settings VALUES('8','ios_live_control','off','2022-11-07 05:05:37','2022-11-07 05:05:37');
INSERT INTO settings VALUES('9','privacy_policy','https://superfootball.com/','2022-11-07 05:05:37','2022-11-07 05:05:37');
INSERT INTO settings VALUES('10','facebook','https://www.facebook.com/','2022-11-07 05:05:37','2022-11-17 09:34:03');
INSERT INTO settings VALUES('11','youtube','http://youtube.com/','2022-11-07 05:05:37','2022-11-17 09:34:03');
INSERT INTO settings VALUES('12','instagram','https://instagram.com/','2022-11-07 05:05:37','2022-11-17 09:34:03');
INSERT INTO settings VALUES('13','server','[\"http:\\/\\/localhost\\/rootstream\\/\"]','2022-11-17 09:40:03','2022-11-17 10:14:16');
INSERT INTO settings VALUES('14','icon','icon.png','2022-11-17 09:44:41','2022-11-17 09:44:41');



DROP TABLE IF EXISTS sports_types;

CREATE TABLE `sports_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sports_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sports_skq` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sports_types_sports_name_unique` (`sports_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO sports_types VALUES('1','Cricket','Cricket_iwYndWAO','1','2022-11-10 05:30:05','2022-11-10 05:30:05');
INSERT INTO sports_types VALUES('2','Football','Football_VlmuCZQm','1','2022-11-10 05:30:15','2022-11-10 05:30:15');



DROP TABLE IF EXISTS streaming_sources;

CREATE TABLE `streaming_sources` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `match_id` bigint(20) unsigned NOT NULL,
  `stream_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stream_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resulation` varchar(31) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stream_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stream_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `block_country` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_block_them` int(11) NOT NULL,
  `position` bigint(20) NOT NULL DEFAULT 99999999999,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO streaming_sources VALUES('25','2','Link 1','web','480p','http://localhost/rootstream/live_matches/create','','','Algeria,Angola','1','99999999999','2022-11-15 04:58:46','2022-11-15 04:58:46');
INSERT INTO streaming_sources VALUES('26','2','Link 2','restricted','480p','http://localhost/rootstream/live_matches/create','','{\"Content-Type\":\"application\\/json; charset=UTF-8\",\"Tag\":\"2\",\"Tag2\":\"3\"}','India,Iraq,Pakistan','1','99999999999','2022-11-15 04:58:46','2022-11-15 04:58:46');
INSERT INTO streaming_sources VALUES('27','2','a','restricted','1080p','http://localhost/rootstream/live_matches/2/edit','','{\"Content-Type\":\"application\\/json; charset=UTF-8\"}','Albania,American Samoa','1','99999999999','2022-11-15 04:58:46','2022-11-15 04:58:46');
INSERT INTO streaming_sources VALUES('28','2','Thailand','web','1080p','http://localhost/rootstream/live_matches/2/edit','','','','0','99999999999','2022-11-15 04:58:46','2022-11-15 04:58:46');



DROP TABLE IF EXISTS subscriptions;

CREATE TABLE `subscriptions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` int(11) NOT NULL,
  `platform` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` bigint(20) NOT NULL DEFAULT 99999999999,
  `app_id` bigint(20) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO subscriptions VALUES('1','Golden','[{\"description\":\"Test\",\"image\":null},{\"description\":\"Test\",\"image\":null}]','year','12','ios','12345','1','6','1','2022-11-16 15:04:39','2022-11-16 15:53:23');
INSERT INTO subscriptions VALUES('2','Silver','[{\"description\":\"sdsd\",\"image\":null}]','month','3','android','assda','2','6','1','2022-11-16 15:43:17','2022-11-16 15:53:23');



DROP TABLE IF EXISTS users;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'public/default/profile.png',
  `apps` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `app_id` bigint(20) DEFAULT NULL,
  `provider` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'email',
  `subscription_id` bigint(20) NOT NULL DEFAULT 0,
  `expired_at` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO users VALUES('1','Muhammad Anisuzzaman','anisseam238@gmail.com','','','$2y$10$evGmVHCf6psxqsae/OYX9Oj473FSO/9QRxxzRzICrZCQlIk3zgEny','admin','public/default/profile.png','','','email','0','','','1','','','');
INSERT INTO users VALUES('3','Test','6_test@email.com','','','$2y$10$eVdZYhlFUI/DwKmP/yGnYOwTbDcc6w9nNnx7a/MjMc/igzBVJd2e6','user','public/uploads/images/users/1668665571.png','','6','email','1','','','1','','2022-11-17 06:12:51','2022-11-17 06:12:51');



