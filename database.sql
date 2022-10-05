CREATE DATABASE IF NOT EXISTS `check24`;
USE `check24`;

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

INSERT INTO `articles` (`id`, `user_id`, `title`, `text`, `created_at`) VALUES
	(1, 1, 'Arm Helps Semiconductor Partners Leverage Its Technology', 'Originally Acorn RISC Machine, Arm Technologies, or just Arm, was started in 1990 by a group of British engineers who designed the early reduced instruction set computer (RISC) processors. Their first processors were used in the original Acorn Archimedes as one of the first RISC machines.\r\n\r\nToday, every smartphone, tablet, smart TV, wearable, and most connected devices use Arm technology. Furthermore, Arm-based CPUs have become the preferred choice for cloud servers in the past few years. Additionally, the IP is the core of Apple’s new silicon for MAC computers, replacing Intel CPUs.', '2022-10-05 18:10:51'),
	(2, 1, 'Future-Proof Your Team to Drive Results', 'Over the last 60 years, a college degree or a technical skilled labor certificate was the key to beginning work and maintaining long-standing employment. During the last decade, requirements have shifted. And post-COVID, the ways of working and team collaboration are changing even more rapidly.\r\n\r\nDisruption is real, and service providers, including VAR partners, must adapt to support their clients. According to Gartner Research, 29% of the skills listed in 2018 job postings for IT, finance, and sales are no longer required in 2022.\r\n\r\nThe pandemic accelerated corporate investment in digital technology and the adoption of Agile approaches. With automation taking over low-skilled jobs and most jobs requiring some level of technical capability, leaders must identify and reskill workers toward expertise that will drive successful outcomes for individuals and the organization.\r\n\r\nGiven the ongoing challenge of the Great Resignation, companies are relying more on partner firms to provide key capabilities. Companies are moving toward Agile delivery models, including team-driven POD (product-oriented delivery). So, how can leaders best support their business while ensuring the success of high-performing individuals, teams, and third-party partners?\r\n\r\n', '2022-10-05 18:11:16'),
	(3, 1, 'How to Attract Top Talent in a Highly Competitive Labor Market', 'While the employees at your company have always been mission critical, in today’s business landscape, more than ever, the difference between thriving and struggling comes down to the folks steering the ship.\r\n\r\nAt the same time, the labor market has never been tighter. Due to the pandemic and the “Great Resignation,” identifying, attracting, and hiring top talent has become increasingly difficult.\r\n\r\nChannel partners need top employees to thrive but are also faced with financial uncertainties and limited budgets. This article explores some of the ways through which you can bring in top talent to your organization — even in today’s competitive talent market.', '2022-10-05 18:11:36'),
	(4, 1, 'My last post for today', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', '2022-10-05 18:12:09');

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(320) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
	(1, 'check24', 'support@check24.de', 'e10adc3949ba59abbe56e057f20f883e', '2022-10-05 21:07:59');