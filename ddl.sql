-- contact_list.information_types definition

CREATE TABLE `information_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `icon_class_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;


-- contact_list.users definition

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_UN_username` (`username`),
  UNIQUE KEY `users_UN_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;


-- contact_list.`groups` definition

CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text_color` varchar(100) NOT NULL,
  `background_color` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `groups_FK` (`user_id`),
  CONSTRAINT `groups_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;


-- contact_list.password_reset_tokens definition

CREATE TABLE `password_reset_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expiration` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `password_reset_tokens_FK` (`users_id`),
  CONSTRAINT `password_reset_tokens_FK` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- contact_list.contact_groups definition

CREATE TABLE `contact_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `contact_groups_UN` (`contact_id`,`group_id`),
  KEY `contact_groups_FK` (`group_id`),
  CONSTRAINT `contact_groups_FK` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  CONSTRAINT `contact_groups_FK_1` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;


-- contact_list.contact_information definition

CREATE TABLE `contact_information` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `value` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_information_FK_1` (`type_id`),
  KEY `contact_information_FK` (`contact_id`),
  CONSTRAINT `contact_information_FK` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `contact_information_FK_1` FOREIGN KEY (`type_id`) REFERENCES `information_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;


-- contact_list.contact_link definition

CREATE TABLE `contact_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_id_1` int(11) NOT NULL,
  `contact_id_2` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_link_FK` (`contact_id_1`),
  KEY `contact_link_FK_1` (`contact_id_2`),
  CONSTRAINT `contact_link_FK` FOREIGN KEY (`contact_id_1`) REFERENCES `contacts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `contact_link_FK_1` FOREIGN KEY (`contact_id_2`) REFERENCES `contacts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- contact_list.contact_notes definition

CREATE TABLE `contact_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) NOT NULL,
  `note` text NOT NULL,
  `hidden` tinyint(1) NOT NULL DEFAULT '0',
  `inserted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `contact_notes_FK` (`contact_id`),
  CONSTRAINT `contact_notes_FK` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;


-- contact_list.contacts definition

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `nickname` varchar(100) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `profile_photo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contacts_FK` (`user_id`),
  KEY `contacts_FK_1` (`profile_photo`),
  CONSTRAINT `contacts_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `contacts_FK_1` FOREIGN KEY (`profile_photo`) REFERENCES `photos` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;


-- contact_list.photos definition

CREATE TABLE `photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(200) NOT NULL,
  `contact_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `photos_FK` (`contact_id`),
  CONSTRAINT `photos_FK` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;