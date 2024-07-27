-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table ticket.addresses
CREATE TABLE IF NOT EXISTS `addresses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `company` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_1` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `city` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `addresses_user_id_foreign` (`user_id`),
  CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.addresses: ~4 rows (approximately)
INSERT INTO `addresses` (`id`, `user_id`, `company`, `address_1`, `address_2`, `city`, `state`, `post_code`, `country`, `phone`, `created_at`, `updated_at`) VALUES
	(1, 4, 'Hoppe, Gaylord and Mann', '894 Parker Drive\nWehnertown, NJ 02035-7898', '6645 Millie Trace Apt. 175\nEast Reganton, MA 72274', 'Alicehaven', 'Vermont', '17012', 'Mongolia', '(463) 718-2633', '2023-09-09 00:34:44', '2023-09-09 00:34:44'),
	(2, 5, 'Thiel Group', '233 Baumbach Lakes Apt. 973\nMarychester, VT 25799-9468', '8006 Macejkovic Way\nWolftown, ME 66777-6933', 'Hermanbury', 'North Carolina', '55710', 'Cote d\'Ivoire', '+15707344700', '2023-09-09 00:34:44', '2023-09-09 00:34:44'),
	(3, 5, 'Kertzmann-Gorczany', '987 Raegan Ramp\nPort Vadashire, FL 21836-6313', '129 Pfannerstill Meadow\nHowellmouth, AK 91491-5829', 'Kiratown', 'New Jersey', '50673-6349', 'Niue', '212-692-0198', '2023-09-09 00:34:44', '2023-09-09 00:34:44'),
	(5, 3, 'Robel, Crona and Lemke', '752 Gaetano Glen\nNorth Lillianamouth, MA 00473-9569', '73380 Orn Plains Suite 977\nWest Winston, MD 83961', 'South Zoila', 'Kansas', '67705', 'Togo', '380.742.0965', '2023-09-09 00:34:44', '2023-09-09 00:34:44');

-- Dumping structure for table ticket.attributes
CREATE TABLE IF NOT EXISTS `attributes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `attributes_product_id_foreign` (`product_id`),
  CONSTRAINT `attributes_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.attributes: ~0 rows (approximately)

-- Dumping structure for table ticket.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int unsigned DEFAULT NULL,
  `order` int NOT NULL DEFAULT '1',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`),
  KEY `categories_parent_id_foreign` (`parent_id`),
  CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.categories: ~2 rows (approximately)
INSERT INTO `categories` (`id`, `parent_id`, `order`, `name`, `slug`, `created_at`, `updated_at`) VALUES
	(1, NULL, 1, 'Spis rejs og (op)lev', 'category-1', '2023-09-08 23:30:27', '2024-03-23 16:03:04'),
	(2, NULL, 1, 'Artikler og nyheder', 'category-2', '2023-09-08 23:30:27', '2024-03-23 16:03:17');

-- Dumping structure for table ticket.cities
CREATE TABLE IF NOT EXISTS `cities` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.cities: ~6 rows (approximately)
INSERT INTO `cities` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
	(1, 'Århus Danmark', 'Århus Danmark', '2023-09-19 04:28:00', '2023-09-26 17:05:12'),
	(2, 'Kusadasi Tyrkiet', 'Kusadasi Tyrkiet', '2023-09-19 04:28:00', '2023-09-26 17:04:15'),
	(3, 'London England', 'London England', '2023-09-19 04:29:00', '2023-09-26 17:04:51'),
	(4, 'København Danmark', 'Kobenhavn Danmark', '2023-09-26 17:03:00', '2023-09-26 17:04:34'),
	(5, 'Rønne Bornholm', 'ronne-bornholm', '2023-10-02 19:07:46', '2023-10-02 19:07:46'),
	(6, 'Manchester England', 'manchester', '2023-10-23 16:56:00', '2023-10-23 16:56:52');

-- Dumping structure for table ticket.contacts
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.contacts: ~45 rows (approximately)
INSERT INTO `contacts` (`id`, `name`, `email`, `phone`, `subject`, `message`, `created_at`, `updated_at`) VALUES
	(79, 'Mike Thomas', 'peteradjounc@gmail.com', '86436887737', 'Whitehat SEO for halaldeals.dk', 'Hello \r\n \r\nI have just verified your SEO on  halaldeals.dk for its SEO Trend and saw that your website could use an upgrade. \r\n \r\nWe will improve your ranks organically and safely, using only state of the art AI and whitehat methods, while providing monthly reports and outstanding support. \r\n \r\nMore info: \r\nhttps://www.digital-x-press.com/unbeatable-seo/ \r\n \r\n \r\nRegards \r\nMike Thomas\r\n \r\nDigital X SEO Experts', '2024-03-27 12:39:08', '2024-03-27 12:39:08'),
	(80, 'RamonPab', 'chitchat.ecosystem@gmail.com', '82689992883', 'Happy Easter! A Social AI gift for you', 'ChitChat app, the fast growing fintech social media ecosystem embraced by businesses for bringing socials and markets into one experience — is offering businesses up to 70% discount on corporate subscriptions this Easter. Download the free android version ‘ChitChat by ikeSOFT’ on the PlayStore to see why it is fast becoming  the MVP of social media, with its social audio rooms, social gifting.dashboard, digital shopping channels, etc. Use your credentials to log into the web platform https://www.chitchatchannel.com/  for the pro-version and discounts. Or vice-versa.', '2024-04-01 14:51:52', '2024-04-01 14:51:52'),
	(81, 'Mike Jenkin', 'mikeadulp@gmail.com', '81385213268', 'NEW: Semrush Backlinks', 'Greetings \r\n \r\nThis is Mike Jenkin\r\n \r\nLet me present you our latest research results from our constant SEO feedbacks that we have from our plans: \r\n \r\nhttps://www.strictlydigital.net/product/semrush-backlinks/ \r\n \r\nThe new Semrush Backlinks, which will make your halaldeals.dk SEO trend have an immediate push. \r\nThe method is actually very simple, we are building links from domains that have a high number of keywords ranking for them.  \r\n \r\nForget about the SEO metrics or any other factors that so many tools try to teach you that is good. The most valuable link is the one that comes from a website that has a healthy trend and lots of ranking keywords. \r\nWe thought about that, so we have built this plan for you \r\n \r\nCheck in detail here: \r\nhttps://www.strictlydigital.net/product/semrush-backlinks/ \r\n \r\nCheap and effective \r\n \r\nTry it anytime soon \r\n \r\nRegards \r\nMike Jenkin\r\n \r\nmike@strictlydigital.net', '2024-04-02 18:24:00', '2024-04-02 18:24:00'),
	(82, 'Syed Atif', 'pr5yukr3hkpq@opayq.com', '81269551552', 'Capital Business Funding', 'Hello, \r\n \r\nWe provide funding through our venture capital company to both start-up and existing companies either looking for funding for expansion or to accelerate growth in their company. \r\nWe have a structured joint venture investment plan in which we are interested in an annual return on investment not more than 10% ROI. We are also currently structuring a convertible debt and loan financing of 3% interest repayable annually with no early repayment penalties. \r\n \r\nWe would like to review your business plan or executive summary to understand a much better idea of your business and what you are looking to do, this will assist in determining the best possible investment structure we can pursue and discuss more extensively. \r\n \r\n \r\nI hope to hear back from you soon. \r\n \r\nSincerely, \r\n \r\nSyed Atif \r\nInvestment Director \r\nDevcorp International E.C. \r\nP.O Box 10236 Shop No. 305 \r\nFlr 3 Manama Centre, Bahrain \r\nEmail: syedatif1001@gmail.com \r\nWebsite: https://devcorpinternational.com', '2024-04-04 12:54:02', '2024-04-04 12:54:02'),
	(83, 'Mike Walkman', 'mikeNuggrigree@gmail.com', '85498762446', 'Domain Authority of your halaldeals.dk', 'Hi there, \r\n \r\nI have reviewed your domain in MOZ and have observed that you may benefit from an increase in authority. \r\n \r\nOur solution guarantees you a high-quality domain authority score within a period of three months. This will increase your organic visibility and strengthen your website authority, thus making it stronger against Google updates. \r\n \r\nCheck out our deals for more details. \r\nhttps://www.monkeydigital.co/domain-authority-plan/ \r\n \r\nNEW: Ahrefs Domain Rating \r\nhttps://www.monkeydigital.co/ahrefs-seo/ \r\n \r\n \r\nThanks and regards \r\nMike Walkman', '2024-04-11 12:02:17', '2024-04-11 12:02:17'),
	(84, 'Mike Mercer', 'mikeJagJeortidoRaive@gmail.com', '87881942944', 'Increase sales for your local business', 'This service is perfect for boosting your local business\' visibility on the map in a specific location. \r\n \r\nWe provide Google Maps listing management, optimization, and promotion services that cover everything needed to rank in the Google 3-Pack. \r\n \r\nMore info: \r\nhttps://www.speed-seo.net/ranking-in-the-maps-means-sales/ \r\n \r\n \r\nThanks and Regards \r\nMike Mercer\r\n \r\n \r\nPS: Want a ONE-TIME comprehensive local plan that covers everything? \r\nhttps://www.speed-seo.net/product/local-seo-bundle/', '2024-04-11 12:11:37', '2024-04-11 12:11:37'),
	(85, 'Mike Richards', 'mikeTwekly@gmail.com', '89842489549', 'Collaboration request', 'Hi there, \r\n \r\nMy name is Mike from Monkey Digital, \r\n \r\nAllow me to present to you a lifetime revenue opportunity of 35% \r\nThat\'s right, you can earn 35% of every order made by your affiliate for life. \r\n \r\nSimply register with us, generate your affiliate links, and incorporate them on your website, and you are done. It takes only 5 minutes to set up everything, and the payouts are sent each month. \r\n \r\nClick here to enroll with us today: \r\nhttps://www.monkeydigital.org/affiliate-dashboard/ \r\n \r\nThink about it, \r\nEvery website owner requires the use of search engine optimization (SEO) for their website. This endeavor holds significant potential for both parties involved. \r\n \r\nThanks and regards \r\nMike Richards\r\n \r\nMonkey Digital', '2024-04-12 04:28:52', '2024-04-12 04:28:52'),
	(86, 'Mike Young', 'mikeNuggrigree@gmail.com', '85533173754', 'FREE fast ranks for halaldeals.dk', 'Hi there \r\n \r\nJust checked your halaldeals.dk baclink profile, I noticed a moderate percentage of toxic links pointing to your website \r\n \r\nWe will investigate each link for its toxicity and perform a professional clean up for you free of charge. \r\n \r\nStart recovering your ranks today: \r\nhttps://www.hilkom-digital.de/professional-linksprofile-clean-up-service/ \r\n \r\nRegards \r\nMike Young\r\nHilkom Digital SEO Experts \r\nhttps://www.hilkom-digital.de/', '2024-04-18 12:57:46', '2024-04-18 12:57:46'),
	(87, 'Mike Goldman', 'peteradjounc@gmail.com', '81263897616', 'Increase sales for your local business', 'Hi there \r\n \r\nAre you tired of spending money on advertising that doesn’t work? \r\nWe have the right strategy for you, to meet the right audience within your City boundaries. \r\n \r\nB2B Local City Marketing that works: \r\nhttps://www.onlinelocalmarketing.org/product/local-research-advertising/ \r\n \r\nWith our innovative marketing approach, you will receive calls, leads, and website interactions within a week. \r\n \r\nRegards \r\nMike Goldman\r\n https://www.onlinelocalmarketing.org', '2024-04-20 10:50:28', '2024-04-20 10:50:28'),
	(88, 'Mike Tracey', 'peteradjounc@gmail.com', '83696917211', 'Whitehat SEO for halaldeals.dk', 'Good Day \r\n \r\nI have just analyzed  halaldeals.dk for the ranking keywords and saw that your website could use an upgrade. \r\n \r\nWe will increase your ranks organically and safely, using only state of the art AI and whitehat methods, while providing monthly reports and outstanding support. \r\n \r\nMore info: \r\nhttps://www.digital-x-press.com/unbeatable-seo/ \r\n \r\n \r\nRegards \r\nMike Tracey\r\n \r\nDigital X SEO Experts', '2024-04-26 09:02:39', '2024-04-26 09:02:39'),
	(89, 'Mike Ferguson', 'mikeadulp@gmail.com', '88872425966', 'NEW: Semrush Backlinks', 'Hello \r\n \r\nThis is Mike Ferguson\r\n \r\nLet me present you our latest research results from our constant SEO feedbacks that we have from our plans: \r\n \r\nhttps://www.strictlydigital.net/product/semrush-backlinks/ \r\n \r\nThe new Semrush Backlinks, which will make your halaldeals.dk SEO trend have an immediate push. \r\nThe method is actually very simple, we are building links from domains that have a high number of keywords ranking for them.  \r\n \r\nForget about the SEO metrics or any other factors that so many tools try to teach you that is good. The most valuable link is the one that comes from a website that has a healthy trend and lots of ranking keywords. \r\nWe thought about that, so we have built this plan for you \r\n \r\nCheck in detail here: \r\nhttps://www.strictlydigital.net/product/semrush-backlinks/ \r\n \r\nCheap and effective \r\n \r\nTry it anytime soon \r\n \r\nRegards \r\nMike Ferguson\r\n \r\nmike@strictlydigital.net', '2024-04-29 21:52:41', '2024-04-29 21:52:41'),
	(90, 'Mike Babcock', 'mikeNuggrigree@gmail.com', '83524829112', 'Domain Authority of your halaldeals.dk', 'Hi there, \r\n \r\nI have reviewed your domain in MOZ and have observed that you may benefit from an increase in authority. \r\n \r\nOur solution guarantees you a high-quality domain authority score within a period of three months. This will increase your organic visibility and strengthen your website authority, thus making it stronger against Google updates. \r\n \r\nCheck out our deals for more details. \r\nhttps://www.monkeydigital.co/domain-authority-plan/ \r\n \r\nNEW: Ahrefs Domain Rating \r\nhttps://www.monkeydigital.co/ahrefs-seo/ \r\n \r\n \r\nThanks and regards \r\nMike Babcock', '2024-05-07 17:04:06', '2024-05-07 17:04:06'),
	(91, 'Mike Benson', 'mikeTwekly@gmail.com', '83869468186', 'Collaboration request', 'Hi there, \r\n \r\nMy name is Mike from Monkey Digital, \r\n \r\nAllow me to present to you a lifetime revenue opportunity of 35% \r\nThat\'s right, you can earn 35% of every order made by your affiliate for life. \r\n \r\nSimply register with us, generate your affiliate links, and incorporate them on your website, and you are done. It takes only 5 minutes to set up everything, and the payouts are sent each month. \r\n \r\nClick here to enroll with us today: \r\nhttps://www.monkeydigital.org/affiliate-dashboard/ \r\n \r\nThink about it, \r\nEvery website owner requires the use of search engine optimization (SEO) for their website. This endeavor holds significant potential for both parties involved. \r\n \r\nThanks and regards \r\nMike Benson\r\n \r\nMonkey Digital', '2024-05-09 12:41:00', '2024-05-09 12:41:00'),
	(92, 'Mike Dunce', 'mikeJagJeortidoRaive@gmail.com', '82461525467', 'Increase sales for your local business', 'This service is perfect for boosting your local business\' visibility on the map in a specific location. \r\n \r\nWe provide Google Maps listing management, optimization, and promotion services that cover everything needed to rank in the Google 3-Pack. \r\n \r\nMore info: \r\nhttps://www.speed-seo.net/ranking-in-the-maps-means-sales/ \r\n \r\n \r\nThanks and Regards \r\nMike Dunce\r\n \r\n \r\nPS: Want a ONE-TIME comprehensive local plan that covers everything? \r\nhttps://www.speed-seo.net/product/local-seo-bundle/', '2024-05-09 21:27:58', '2024-05-09 21:27:58'),
	(93, 'Web Financing', 'admin@webfinancingloan.com', '85737942997', 'Eksklusivt lånetilbud', 'Kjære verdsatte kunde, \r\n \r\nVi håper denne meldingen finner deg vel. Dette er Web Financing, og vi er begeistret for å presentere deg et eksklusivt lånetilbud med en årlig rente på 3%. Dette tilbudet er utformet for å gi deg økonomisk støtte og gjøre dine ambisjoner mer overkommelige. Vi forstår viktigheten av økonomisk fleksibilitet og den rollen den spiller i å oppfylle dine drømmer. \r\n \r\nHos Web Financing, griper vi denne muligheten til å gjøre dine planer til virkelighet ved å tilby økonomisk støtte som forstår dine behov og vokser sammen med deg. For mer informasjon om hvordan du starter søknadsprosessen, besøk vår nettside eller kontakt vårt kundeserviceteam. \r\nKontakt os på: admin@webfinancingloan.com \r\n \r\nMed vennlig hilsen, \r\nWeb Financing.', '2024-05-13 13:16:01', '2024-05-13 13:16:01'),
	(94, 'Mike Finch', 'mikeNuggrigree@gmail.com', '86399142912', 'FREE fast ranks for halaldeals.dk', 'Hi there \r\n \r\nJust checked your halaldeals.dk baclink profile, I noticed a moderate percentage of toxic links pointing to your website \r\n \r\nWe will investigate each link for its toxicity and perform a professional clean up for you free of charge. \r\n \r\nStart recovering your ranks today: \r\nhttps://www.hilkom-digital.de/professional-linksprofile-clean-up-service/ \r\n \r\nRegards \r\nMike Finch\r\nHilkom Digital SEO Experts \r\nhttps://www.hilkom-digital.de/', '2024-05-14 08:08:24', '2024-05-14 08:08:24'),
	(95, 'TobiasRom', 'no.reply.OlofJanssen@gmail.com', '87775246988', 'You can count on us for the delivery of your emails.', 'Howdy-doody! halaldeals.dk \r\n \r\nDid you know that it is possible to send business offer according to law? We provide a unique, legal way of sending proposals through feedback forms to cut down on рaрerwork. \r\nSeen as significant, messages sent by means of Feedback Forms are not labeled as spam. \r\nYou can now test out our service without having to pay. \r\nOn your behalf, we can deliver up to 50,000 messages. \r\n \r\nThe cost of sending one million messages is $59. \r\n \r\nThis message was automatically generated. \r\nPlease use the contact details below to get in touch with us. \r\n \r\nContact us. \r\nTelegram - https://t.me/FeedbackFormEU \r\nSkype  live:feedbackform2019 \r\nWhatsApp  +375259112693 \r\nWhatsApp  https://wa.me/+375259112693 \r\n \r\nWe only use chat for communication.', '2024-05-18 04:38:21', '2024-05-18 04:38:21'),
	(96, 'RonaldLok', 'crypto.adviser00004@gmail.com', '87466423146', 'Introducing a Must-See VISA Debit Card for Cryptocurrency Users', 'Hi, I\'m Michael Yoshioka from Crypto Adviser LTD. Here\'s a wallet & debit card for cryptocurrencies. Use your crypto assets more easily with this. \r\n \r\nRedotPay WALLET: \r\nRedotPay partners with Binance, offering a popular wallet & VISA debit card. Pay directly with crypto. Apply for the card by installing the wallet app from the URL, App Store, or Google Play. \r\n \r\nWallet Fee: Free \r\nCard Fee: Virtual VISA $5 / Physical VISA $100 \r\nURL: https://redotpay.cards/register/ \r\n \r\nOCTPASS WALLET: \r\nJDB Bank, Laos\'s largest private bank, partners with the "Octopus" wallet. Apply for a VISA debit cash card. Withdraw cash from ATMs and make international transfers. \r\n \r\nWallet Fee: Free \r\nBank Account Fee: $800 ($300 deposit) \r\nURL: https://laos-bank.jp/en/ \r\n \r\nUse these cards at VISA stores worldwide. Get an affiliate account by applying from the URLs above. \r\n \r\nAffiliate rewards: Up to $40/card + up to 0.25% fee for RedotPay, and up to $150/card for JDB Bank. \r\n \r\nFor questions, contact: \r\n \r\nCrypto Adviser LTD \r\nMichael Yoshioka \r\nE-mail: info@crypto-adviser.co', '2024-05-18 14:27:23', '2024-05-18 14:27:23'),
	(97, 'Angel Kuester', 'angel.kuester50@googlemail.com', '176151293', 'Unleash your inner author with AI: Create eBooks in seconds!', 'Hi there,\r\n\r\nI recently came across your website on halaldeals.dk and found it very interesting. I was curious, have you ever considered creating an eBook out of your website content?\r\n\r\nThere are tools available, that allow you to easily convert website content into a well-designed eBook. This could be a great way to repurpose your existing content and potentially reach a new audience.\r\n\r\nOf course, I understand this might not be something you\'re interested in, but I just wanted to share the possibility!\r\n\r\nAnyway, here is the tool I had in mind. It\'s only $16.95 so worth checking out: \r\nhttps://furtherinfo.org/lgb7\r\n\r\nBest regards,\r\nAngel\r\n\r\nUnsubscribe: https://removeme.click/wp/unsubscribe.php?d=halaldeals.dk', '2024-05-21 22:43:11', '2024-05-21 22:43:11'),
	(98, 'Emily Jones', 'emilyjones2250@gmail.com', '4743860', 'Youtube Promotion: 700 new subscribers each month', 'Hi there,\r\n\r\nWe run a YouTube growth service, which increases your number of subscribers both safely and practically.\r\n\r\nWe go beyond just subscriber numbers. We focus on attracting viewers genuinely interested in your niche, leading to long-term engagement with your content. Our approach leverages optimization, community building, and content promotion for sustainable growth, not quick fixes. Additionally, a dedicated team analyzes your channel and creates a personalized plan to unlock your full potential, all without relying on bots.\r\n\r\nOur packages start from just $60 (USD) per month.\r\n\r\nWould this be of interest?\r\n\r\nKind Regards,\r\nEmily', '2024-05-22 16:49:50', '2024-05-22 16:49:50'),
	(99, 'Mike Nevill', 'peteradjounc@gmail.com', '83934549179', 'Whitehat SEO for halaldeals.dk', 'Howdy \r\n \r\nI have just took a look on your SEO for  halaldeals.dk for its SEO Trend and saw that your website could use an upgrade. \r\n \r\nWe will enhance your ranks organically and safely, using only state of the art AI and whitehat methods, while providing monthly reports and outstanding support. \r\n \r\nMore info: \r\nhttps://www.digital-x-press.com/unbeatable-seo/ \r\nWhatsapp us: https://wa.link/fqchim \r\n \r\nRegards \r\nMike Nevill\r\n \r\nDigital X SEO Experts', '2024-05-25 11:15:04', '2024-05-25 11:15:04'),
	(100, 'Emily Jones', 'emilyjones2250@gmail.com', '24439769', 'Grow your Youtube channel', 'Hi there,\r\n\r\nWe run a Youtube growth service, where we can increase your subscriber count safely and practically. \r\n\r\n- Guaranteed: We guarantee to gain you 700-1500 new subscribers each month.\r\n- Real, human subscribers who subscribe because they are interested in your channel/videos.\r\n- Safe: All actions are done, without using any automated tasks / bots.\r\n\r\nOur price is just $60 (USD) per month and we can start immediately.\r\n\r\nIf you are interested then we can discuss further.\r\n\r\nKind Regards,\r\nEmily', '2024-05-29 18:48:42', '2024-05-29 18:48:42'),
	(101, 'Mike Dutton', 'mikeadulp@gmail.com', '85239382538', 'NEW: Semrush Backlinks', 'Howdy \r\n \r\nThis is Mike Dutton\r\n \r\nLet me introduce to you our latest research results from our constant SEO feedbacks that we have from our plans: \r\n \r\nhttps://www.strictly-digital.com/semrush-backlinks/ \r\n \r\nThe new Semrush Backlinks, which will make your halaldeals.dk SEO trend have an immediate push. \r\nThe method is actually very simple, we are building links from domains that have a high number of keywords ranking for them.  \r\n \r\nForget about the SEO metrics or any other factors that so many tools try to teach you that is good. The most valuable link is the one that comes from a website that has a healthy trend and lots of ranking keywords. \r\nWe thought about that, so we have built this plan for you \r\n \r\nCheck in detail here: \r\nhttps://www.strictly-digital.com/semrush-backlinks/ \r\n \r\nCheap and effective \r\nWhatsapp us: https://wa.link/on3cru \r\nTry it anytime soon \r\n \r\nRegards \r\nMike Dutton\r\n \r\nmike@strictlydigital.net', '2024-05-31 04:43:45', '2024-05-31 04:43:45'),
	(102, 'Georgina Haynes', 'georginahaynes620@gmail.com', '680757978', 'Explainer Video for your website?', 'Hi,\r\n\r\nI just visited halaldeals.dk and wondered if you\'d ever thought about having an engaging video to explain what you do?\r\n\r\nOur videos cost just $195 for a 30 second video ($239 for 60 seconds) and include a full script, voice-over and video.\r\n\r\nI can show you some previous videos we\'ve done if you want me to send some over. Let me know if you\'re interested in seeing samples of our previous work.\r\n\r\nRegards,\r\nGeorgina\r\n\r\nUnsubscribe: https://removeme.click/ev/unsubscribe.php?d=halaldeals.dk', '2024-06-02 00:51:37', '2024-06-02 00:51:37'),
	(103, 'Mike Wesley', 'mikeNuggrigree@gmail.com', '84861875182', 'Domain Authority of your halaldeals.dk', 'Hi there, \r\n \r\nI have reviewed your domain in MOZ and have observed that you may benefit from an increase in authority. \r\n \r\nOur solution guarantees you a high-quality domain authority score within a period of three months. This will increase your organic visibility and strengthen your website authority, thus making it stronger against Google updates. \r\n \r\nCheck out our deals for more details. \r\nhttps://www.monkeydigital.co/domain-authority-plan/ \r\n \r\n \r\nThanks and regards \r\nMike Wesley\r\n \r\nMonkey Digital \r\nhttps://www.monkeydigital.co/whatsapp-us/', '2024-06-05 12:59:36', '2024-06-05 12:59:36'),
	(104, 'Oman Rook', 'pr5yukr3hkpq@opayq.com', '87665478289', 'Need Business Capital Funding', 'Hello, \r\n \r\nOne of the most significant hurdles for startups and existing businesses is securing the necessary funding to fuel their growth and bring their ideas to fruition. Our company specializes in providing tailored financing solutions to both startups and existing businesses. We offer debt financing with a competitive interest rate designed to support capital growth without burdening the business owners. \r\n \r\nOur loan interest rate is set at a favorable 3% annually, and with no early payment penalties, giving you the flexibility to manage your finances with ease. For those seeking equity financing, our venture capital funding option provides the capital you need to fuel your expansion. With just a modest 10% equity stake, you can access the resources necessary to scale your business while retaining control and ownership. We recognize these challenges and are committed to providing startups with flexible financing options tailored to their unique needs. \r\n \r\nWe are happy to review your pitch deck or executive summary to better understand your business and this will assist in determining the best possible investment structure that we can pursue and discuss extensively. \r\n \r\nI look forward to further communication. \r\n \r\nBest Regard, \r\nOman Rook \r\nExecutive Investment Consultant/Director \r\nCateus Investment Company (CIC) \r\n2401 AlMoayyed Tower Seef District \r\nManama - Kingdom of Bahrain \r\nEmail: oman.rook@cateusinvestmentgroup.com \r\ncateusgroup@gmail.com', '2024-06-05 13:47:23', '2024-06-05 13:47:23'),
	(105, 'Gertie Govan', 'gertie.govan@msn.com', '625794357', 'Tired of Monthly Hosting Fees?', 'Hi there,\r\n\r\nAre you tired of paying monthly fees for website hosting, cloud storage, and funnels?\r\n\r\nWe offer a revolutionary solution: host unlimited websites, files, and videos for a single, low one-time fee. No more monthly payments.\r\n\r\nLearn more: https://furtherinfo.org/0wg3\r\n\r\nHere\'s what you get:\r\n\r\nUltra-fast hosting powered by Intel® Xeon® CPU technology\r\nUnlimited website hosting\r\nUnlimited cloud storage\r\nUnlimited video hosting\r\nUnlimited funnel creation\r\nFree SSL certificates for all domains and files\r\n99.999% uptime guarantee\r\n24/7 customer support\r\nEasy-to-use cPanel\r\n365-day money-back guarantee\r\n\r\nPlus, get these exclusive bonuses when you act now:\r\n\r\n60+ reseller licenses (sell hosting to your clients!)\r\n10 Fast-Action Bonuses worth over $19,997 (including AI tools, traffic generation, and more!)\r\n\r\nDon\'t miss out on this limited-time offer! The price is about to increase, and this one-time fee won\'t last forever.\r\n\r\nClick here to learn more: https://furtherinfo.org/0wg3\r\n\r\nGertie', '2024-06-05 13:49:05', '2024-06-05 13:49:05'),
	(106, 'Mike Richards', 'mikeJagJeortidoRaive@gmail.com', '83355559485', 'Increase sales for your local business', 'This service is perfect for boosting your local business\' visibility on the map in a specific location. \r\n \r\nWe provide Google Maps listing management, optimization, and promotion services that cover everything needed to rank in the Google 3-Pack. \r\n \r\nMore info: \r\nhttps://www.speed-seo.co/ranking-in-the-maps-means-sales/ \r\n \r\nThanks and Regards \r\nMike Richards\r\n \r\nhttps://www.speed-seo.co/whatsapp-us/', '2024-06-05 14:23:17', '2024-06-05 14:23:17'),
	(107, 'Mike Garrison', 'mikeTwekly@gmail.com', '85124623712', 'Collaboration request', 'Hi there, \r\n \r\nMy name is Mike from Monkey Digital, \r\n \r\nAllow me to present to you a lifetime revenue opportunity of 35% \r\nThat\'s right, you can earn 35% of every order made by your affiliate for life. \r\n \r\nSimply register with us, generate your affiliate links, and incorporate them on your website, and you are done. It takes only 5 minutes to set up everything, and the payouts are sent each month. \r\n \r\nClick here to enroll with us today: \r\nhttps://www.monkeydigital.co/join-affiliates/ \r\n \r\nThink about it, \r\nEvery website owner requires the use of search engine optimization (SEO) for their website. This endeavor holds significant potential for both parties involved. \r\n \r\nThanks and regards \r\nMike Garrison\r\n \r\nMonkey Digital \r\nhttps://www.monkeydigital.co/whatsapp-affiliates/', '2024-06-07 14:23:41', '2024-06-07 14:23:41'),
	(108, 'Hannah Ackerman', 'rachelmanagement@skiff.com', '85324462366', 'Tailored financial Solution', 'Good day, \r\n \r\nWe specialize in consulting for a group of high-net-worth foreign investors, providing exclusive investment opportunities with a 2.5% interest rate, a 2-year grace period, and a repayment term of 10 to 15 years. If you are seeking funding for your business or personal projects, please indicate your interest, and we will reach out to you for a consultation through our official platform. \r\n \r\nThank you for your time and consideration. \r\n \r\nBest regards, \r\n \r\nMrs. Hannah Ackerman \r\n \r\nalternativeconsult@hgdtkbcs-sec.com \r\n \r\nAlternative Finance \r\n \r\nRelationship Manager', '2024-06-08 13:02:26', '2024-06-08 13:02:26'),
	(109, 'Amelia Brown', 'ameliabrown0325@gmail.com', '627751600', 'YouTube Promotion: 700-1500 new subscribers each month', 'Hi there,\r\n\r\nWe run a YouTube growth service, which increases your number of subscribers both safely and practically. \r\n\r\n- We guarantee to gain you 700-1500+ subscribers per month.\r\n- People subscribe because they are interested in your channel/videos, increasing likes, comments and interaction.\r\n- All actions are made manually by our team. We do not use any \'bots\'.\r\n\r\nThe price is just $60 (USD) per month, and we can start immediately.\r\n\r\nIf you have any questions, let me know, and we can discuss further.\r\n\r\nKind Regards,\r\nAmelia\r\n\r\nUnsubscribe: https://removeme.click/yt/unsubscribe.php?d=halaldeals.dk', '2024-06-12 04:27:31', '2024-06-12 04:27:31'),
	(110, 'Mike Flannagan', 'mikeNuggrigree@gmail.com', '81752837522', 'FREE fast ranks for halaldeals.dk', 'Hi there, \r\n \r\nJust checked your halaldeals.dk backlink profile and found a moderate percentage of toxic links pointing to your website. \r\n \r\nBad links happen, and when they do, they put your site at risk. With our free links clean up service, you can take control of your backlink profile through unnatural backlink removal and avoid painful penalties. \r\n \r\nStart recovering your ranks today: \r\nhttps://www.freeseocleanup.com/ \r\n \r\nRegards \r\nMike Flannagan\r\n SEO Expert', '2024-06-14 06:50:31', '2024-06-14 06:50:31'),
	(111, 'EBRAHIM BIN MOHAMED', 'intl.law7@aol.com', '82522311741', 'We are willing to fund your Business/Project', 'Salaam Sir, \r\n \r\nHow are you doing? Are you an entrepreneur/business owner or chief executive officer seeking capital for your business growth or expansion? \r\n \r\nI am contacting you to know if you are open to investors into your company as we are currently providing financial support to companies and individuals for business and project expansion. \r\n \r\nWe also pay success fee commission to individuals who direct clients to us for financing. \r\n \r\nWe. will be willing to partner with you for your business growth. \r\n \r\nReply for further discussions if interested with your business plan or executive summary and Whats App number for an introductory call. \r\n \r\nPlease use the following email to reach me, projectoffice@intltrinvestment.com \r\n \r\nIgnore if not interested. \r\n \r\nAllah Bless, \r\nEBRAHIM BIN MOHAMED \r\nprojectoffice@intltrinvestment.com \r\nInternational Trading & Investment Co', '2024-06-16 21:54:20', '2024-06-16 21:54:20'),
	(112, 'Mike Ferguson', 'peteradjounc@gmail.com', '82134369634', 'Whitehat SEO for halaldeals.dk', 'Hello \r\n \r\nI have just took a look on your SEO for  halaldeals.dk for  the current search visibility and saw that your website could use a push. \r\n \r\nWe will enhance your ranks organically and safely, using only state of the art AI and whitehat methods, while providing monthly reports and outstanding support. \r\n \r\nMore info: \r\nhttps://www.digital-x-press.co/unbeatable-seo/ \r\n \r\nRegards \r\nMike Ferguson\r\n \r\nDigital X SEO Experts \r\nhttps://www.digital-x-press.co/whatsapp-us/', '2024-06-20 16:42:24', '2024-06-20 16:42:24'),
	(113, 'Joanna Riggs', 'joannariggs278@gmail.com', '745189165', 'Video Promotion for your website?', 'Hi,\r\n\r\nI just visited halaldeals.dk and wondered if you\'d ever thought about having an engaging video to explain what you do?\r\n\r\nOur prices start from just $195.\r\n\r\nWe have produced over 500 videos to date and work with both non-animated and animated formats:\r\n\r\nNon-animated example:\r\nhttps://www.youtube.com/watch?v=bA2DyChM4Oc\r\n\r\nAnimated example:\r\nhttps://www.youtube.com/watch?v=JG33_MgGjfc\r\n\r\nLet me know if you\'re interested in learning more and/or have any questions.\r\n\r\nRegards,\r\nJoanna\r\n\r\nUnsubscribe: https://removeme.click/ev/unsubscribe.php?d=halaldeals.dk', '2024-06-21 20:01:08', '2024-06-21 20:01:08'),
	(114, 'Mike Wayne', 'mikeSowlHodo@gmail.com', '89853155955', 'NEW: Semrush Backlinks', 'Howdy \r\n \r\nThis is Mike Wayne\r\n \r\nLet me present you our latest research results from our constant SEO feedbacks that we have from our plans: \r\n \r\nThe new Semrush Backlinks, which will make your halaldeals.dk SEO trend have an immediate push. \r\nThe method is actually very simple, we are building links from domains that have a high number of keywords ranking for them.  \r\n \r\nForget about the SEO metrics or any other factors that so many tools try to teach you that is good. The most valuable link is the one that comes from a website that has a healthy trend and lots of ranking keywords. \r\nWe thought about that, so we have built this plan for you \r\n \r\nCheck in detail here: \r\nhttps://www.strictlydigital.co/semrush-backlinks/ \r\n \r\nCheap and effective \r\nTry it anytime soon \r\n \r\nRegards \r\nMike Wayne\r\n https://www.strictlydigital.co/whatsapp-us/', '2024-06-27 21:08:37', '2024-06-27 21:08:37'),
	(115, 'Mike Leapman', 'mikeadjounc@gmail.com', '86927341291', 'Domain Authority of your halaldeals.dk', 'After reviewing your domain in MOZ, it has come to my attention that you may benefit from an increase in authority. \r\n \r\nOur solution will give you a high-quality domain authority score in three months. This will increase your organic visibility and strengthen your website authority, thus strengthening it against Google updates. \r\n \r\nCheck out our deals for more details. \r\nhttps://www.monkey-seo.com/moz-authority-seo/ \r\n \r\n \r\nThanks and regards \r\nMike Leapman\r\nMonkey Digital \r\nWhatsapp: https://www.monkey-seo.com/whatsapp-us/', '2024-07-02 15:27:29', '2024-07-02 15:27:29'),
	(116, 'Mike Wainwright', 'mikeadjounc@gmail.com', '81532586113', 'Increase rankings with a SEO friendly web design', 'Hi there \r\nI just checked halaldeals.dk ranks and am sorry to bring this up, but it lacks in many areas. \r\n \r\nUnfortunately, building a bunch of links won\'t solve the issue in this case, and a more comprehensive strategy is required. Google has undergone significant changes over the past year, making it nearly impossible to compete for favorable rankings without a well-designed website. \r\n \r\nWe recommend a search engine-friendly website layout to resolve all issues and propel your site to the top. \r\n \r\nYou can check more details here: https://www.speed-seo.org/web-design/ \r\n \r\nThanks for your consideration \r\nMike Wainwright\r\nSpeed Designs \r\nhttps://www.speed-seo.org/whatsapp-us/', '2024-07-02 17:55:36', '2024-07-02 17:55:36'),
	(117, 'Mike Simpson', 'mikeSowlHodo@gmail.com', '88992585459', 'Collaboration request', 'Hi there, \r\n \r\nMy name is Mike from Monkey Digital, \r\n \r\nAllow me to present to you a lifetime revenue opportunity of 35% \r\nThat\'s right, you can earn 35% of every order made by your affiliate for life. \r\n \r\nSimply register with us, generate your affiliate links, and incorporate them on your website, and you are done. It takes only 5 minutes to set up everything, and the payouts are sent each month. \r\n \r\nClick here to enroll with us today: \r\nhttps://www.monkey-seo.org/affiliates/ \r\n \r\nThink about it, \r\nEvery website owner requires the use of search engine optimization (SEO) for their website. This endeavor holds significant potential for both parties involved. \r\n \r\nThanks and regards \r\nMike Simpson\r\n \r\nMonkey Digital \r\nhttps://www.monkey-seo.org/whatsapp-affiliates/', '2024-07-02 23:54:07', '2024-07-02 23:54:07'),
	(118, 'Amelia Brown', 'ameliabrown0325@gmail.com', '3065876557', 'YouTube Promotion: 700-1500 new subscribers each month', 'Hi there,\r\n\r\nWe run a YouTube growth service, which increases your number of subscribers both safely and practically. \r\n\r\n- We guarantee to gain you 700-1500+ subscribers per month.\r\n- People subscribe because they are interested in your channel/videos, increasing likes, comments and interaction.\r\n- All actions are made manually by our team. We do not use any \'bots\'.\r\n\r\nThe price is just $60 (USD) per month, and we can start immediately.\r\n\r\nIf you have any questions, let me know, and we can discuss further.\r\n\r\nKind Regards,\r\nAmelia\r\n\r\nUnsubscribe: https://removeme.click/yt/unsubscribe.php?d=halaldeals.dk', '2024-07-06 22:51:58', '2024-07-06 22:51:58'),
	(119, 'Shanel Burdge', 'burdge.shanel29@msn.com', '533133230', 'Tired of Monthly Hosting Fees?', 'Hi there,\r\n\r\nAre you tired of paying monthly fees for website hosting, cloud storage, and funnels?\r\n\r\nWe offer a revolutionary solution: host unlimited websites, files, and videos for a single, low one-time fee. No more monthly payments.\r\n\r\nHere\'s what you get:\r\n\r\nUltra-fast hosting powered by Intel® Xeon® CPU technology\r\nUnlimited website hosting\r\nUnlimited cloud storage\r\nUnlimited video hosting\r\nUnlimited funnel creation\r\nFree SSL certificates for all domains and files\r\n99.999% uptime guarantee\r\n24/7 customer support\r\nEasy-to-use cPanel\r\n365-day money-back guarantee\r\n\r\nPlus, get these exclusive bonuses when you act now:\r\n\r\n60+ reseller licenses (sell hosting to your clients!)\r\n10 Fast-Action Bonuses worth over $19,997 (including AI tools, traffic generation, and more!)\r\n\r\nDon\'t miss out on this limited-time offer! The price is about to increase, and this one-time fee won\'t last forever.\r\n\r\nClick here to learn more: https://furtherinfo.org/yarx\r\n\r\nShanel\r\n\r\nIf you do not wish to receive any further offers:\r\nhttps://removeme.click/wp/unsubscribe.php?d=halaldeals.dk', '2024-07-11 09:42:39', '2024-07-11 09:42:39'),
	(120, 'Joanna Riggs', 'joannariggs278@gmail.com', 'Xxz i wrfny', 'Video Promotion for halaldeals.dk?', 'Hi,\r\n\r\nI just visited halaldeals.dk and wondered if you\'d ever thought about having an engaging video to explain what you do?\r\n\r\nOur prices start from just $195.\r\n\r\nLet me know if you\'re interested in seeing samples of our previous work.\r\n\r\nRegards,\r\nJoanna', '2024-07-12 06:04:21', '2024-07-12 06:04:21'),
	(121, 'Mike Wesley', 'peteradjounc@gmail.com', '88438513193', 'Whitehat SEO for halaldeals.dk', 'Good Day \r\n \r\nI have just took an in depth look on your  halaldeals.dk for  the current search visibility and saw that your website could use a boost. \r\n \r\nWe will increase your ranks organically and safely, using only state of the art AI and whitehat methods, while providing monthly reports and outstanding support. \r\n \r\nMore info: \r\nhttps://www.digital-x-press.com/unbeatable-seo/ \r\n \r\nRegards \r\nMike Wesley\r\n \r\nDigital X SEO Experts \r\nhttps://www.digital-x-press.com/whatsapp-us/', '2024-07-18 21:32:26', '2024-07-18 21:32:26'),
	(122, 'Felicity Sauncho', 'felicitysauncho@gmail.com', '382062412', 'Youtube Promotion: 700 new subscribers each month', 'Hi there,\r\n\r\nWe run a Youtube growth service, where we can increase your subscriber count safely and practically. \r\n\r\n- Guaranteed: We guarantee to gain you 700-1500 new subscribers each month.\r\n- Real, human subscribers who subscribe because they are interested in your channel/videos.\r\n- Safe: All actions are done, without using any automated tasks / bots.\r\n\r\nOur price is just $60 (USD) per month and we can start immediately.\r\n\r\nIf you are interested then we can discuss further.\r\n\r\nKind Regards,\r\nFelicity', '2024-07-20 18:52:07', '2024-07-20 18:52:07'),
	(123, 'RaymondThync', 'no.reply.StianDupont@gmail.com', '81499541461', 'Sharing comments via the feedback form.', 'Hi! halaldeals.dk \r\n \r\nDid you know that it is possible to send commercial offers legitimately? \r\nWhen such business proposals are sent, no personal data is used, and messages are sent to forms specifically designed to receive messages and appeals securely. As Feedback Forms messages are considered important, they will not be marked as spam. \r\nCome and give our service a try – it’s free! \r\nYou can rely on us to send up to 50,000 messages. \r\n \r\nThe cost of sending one million messages is $59. \r\n \r\nThis message was automatically generated. \r\n \r\nContact us. \r\nTelegram - https://t.me/FeedbackFormEU \r\nSkype  live:contactform_18 \r\nWhatsApp - +375259112693 \r\nWhatsApp  https://wa.me/+375259112693 \r\nWe only use chat for communication.', '2024-07-21 01:04:17', '2024-07-21 01:04:17');

-- Dumping structure for table ticket.coupons
CREATE TABLE IF NOT EXISTS `coupons` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` bigint unsigned NOT NULL,
  `code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` int NOT NULL,
  `expire_at` date NOT NULL,
  `limit` int NOT NULL,
  `minimum_cart` int NOT NULL,
  `used` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `coupons_shop_id_foreign` (`shop_id`),
  CONSTRAINT `coupons_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.coupons: ~0 rows (approximately)

-- Dumping structure for table ticket.data_rows
CREATE TABLE IF NOT EXISTS `data_rows` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `data_type_id` int unsigned NOT NULL,
  `field` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `browse` tinyint(1) NOT NULL DEFAULT '1',
  `read` tinyint(1) NOT NULL DEFAULT '1',
  `edit` tinyint(1) NOT NULL DEFAULT '1',
  `add` tinyint(1) NOT NULL DEFAULT '1',
  `delete` tinyint(1) NOT NULL DEFAULT '1',
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `order` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `data_rows_data_type_id_foreign` (`data_type_id`),
  CONSTRAINT `data_rows_data_type_id_foreign` FOREIGN KEY (`data_type_id`) REFERENCES `data_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=281 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.data_rows: ~253 rows (approximately)
INSERT INTO `data_rows` (`id`, `data_type_id`, `field`, `type`, `display_name`, `required`, `browse`, `read`, `edit`, `add`, `delete`, `details`, `order`) VALUES
	(1, 1, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, '{}', 1),
	(2, 1, 'name', 'text', 'First Name', 1, 1, 1, 1, 1, 1, '{}', 2),
	(3, 1, 'email', 'text', 'Email', 1, 1, 1, 1, 1, 1, '{}', 4),
	(4, 1, 'password', 'password', 'Password', 1, 0, 0, 1, 1, 0, '{}', 7),
	(5, 1, 'remember_token', 'text', 'Remember Token', 0, 0, 0, 0, 0, 0, '{}', 8),
	(6, 1, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 0, 0, 0, '{}', 9),
	(7, 1, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 10),
	(8, 1, 'avatar', 'image', 'Avatar', 0, 0, 1, 1, 1, 1, '{}', 12),
	(9, 1, 'user_belongsto_role_relationship', 'relationship', 'Role', 0, 1, 1, 1, 1, 0, '{"model":"TCG\\\\Voyager\\\\Models\\\\Role","table":"roles","type":"belongsTo","column":"role_id","key":"id","label":"display_name","pivot_table":"roles","pivot":"0","taggable":"0"}', 6),
	(10, 1, 'user_belongstomany_role_relationship', 'relationship', 'Roles', 0, 0, 1, 1, 1, 0, '{"model":"TCG\\\\Voyager\\\\Models\\\\Role","table":"roles","type":"belongsToMany","column":"id","key":"id","label":"display_name","pivot_table":"user_roles","pivot":"1","taggable":"0"}', 13),
	(11, 1, 'settings', 'hidden', 'Settings', 0, 0, 0, 0, 0, 0, '{}', 14),
	(12, 2, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, NULL, 1),
	(13, 2, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, NULL, 2),
	(14, 2, 'created_at', 'timestamp', 'Created At', 0, 0, 0, 0, 0, 0, NULL, 3),
	(15, 2, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 4),
	(16, 3, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, NULL, 1),
	(17, 3, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, NULL, 2),
	(18, 3, 'created_at', 'timestamp', 'Created At', 0, 0, 0, 0, 0, 0, NULL, 3),
	(19, 3, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 4),
	(20, 3, 'display_name', 'text', 'Display Name', 1, 1, 1, 1, 1, 1, NULL, 5),
	(21, 1, 'role_id', 'text', 'Role', 0, 1, 1, 1, 1, 1, '{}', 5),
	(22, 4, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, NULL, 1),
	(23, 4, 'parent_id', 'select_dropdown', 'Parent', 0, 0, 1, 1, 1, 1, '{"default":"","null":"","options":{"":"-- None --"},"relationship":{"key":"id","label":"name"}}', 2),
	(24, 4, 'order', 'text', 'Order', 1, 1, 1, 1, 1, 1, '{"default":1}', 3),
	(25, 4, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, NULL, 4),
	(26, 4, 'slug', 'text', 'Slug', 1, 1, 1, 1, 1, 1, '{"slugify":{"origin":"name"}}', 5),
	(27, 4, 'created_at', 'timestamp', 'Created At', 0, 0, 1, 0, 0, 0, NULL, 6),
	(28, 4, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 7),
	(29, 5, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, '{}', 1),
	(30, 5, 'author_id', 'text', 'Author', 1, 0, 1, 1, 0, 1, '{}', 2),
	(31, 5, 'category_id', 'text', 'Category', 0, 0, 1, 1, 1, 0, '{}', 3),
	(32, 5, 'title', 'text', 'Title', 1, 1, 1, 1, 1, 1, '{}', 4),
	(33, 5, 'excerpt', 'text_area', 'Excerpt', 0, 0, 1, 1, 1, 1, '{}', 5),
	(34, 5, 'body', 'rich_text_box', 'Body', 1, 0, 1, 1, 1, 1, '{}', 6),
	(35, 5, 'image', 'image', 'Post Image', 0, 1, 1, 1, 1, 1, '{"resize":{"width":"1000","height":"null"},"quality":"70%","upsize":true,"thumbnails":[{"name":"medium","scale":"50%"},{"name":"small","scale":"25%"},{"name":"cropped","crop":{"width":"300","height":"250"}}]}', 7),
	(36, 5, 'slug', 'text', 'Slug', 1, 0, 1, 1, 1, 1, '{"slugify":{"origin":"title","forceUpdate":true},"validation":{"rule":"unique:posts,slug"}}', 8),
	(37, 5, 'meta_description', 'text_area', 'Meta Description', 0, 0, 1, 1, 1, 1, '{}', 9),
	(38, 5, 'meta_keywords', 'text_area', 'Meta Keywords', 0, 0, 1, 1, 1, 1, '{}', 10),
	(39, 5, 'status', 'select_dropdown', 'Status', 1, 1, 1, 1, 1, 1, '{"default":"DRAFT","options":{"PUBLISHED":"published","DRAFT":"draft","PENDING":"pending"}}', 11),
	(40, 5, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 0, 0, 0, '{}', 12),
	(41, 5, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 13),
	(42, 5, 'seo_title', 'text', 'SEO Title', 0, 1, 1, 1, 1, 1, '{}', 14),
	(43, 5, 'featured', 'checkbox', 'Featured', 1, 1, 1, 1, 1, 1, '{"on":"on","off":"Off","checked":false}', 15),
	(44, 6, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, '{}', 1),
	(45, 6, 'author_id', 'text', 'Author', 1, 0, 0, 0, 0, 0, '{}', 2),
	(46, 6, 'title', 'text', 'Title', 1, 1, 1, 1, 1, 1, '{}', 3),
	(47, 6, 'excerpt', 'text_area', 'Excerpt', 0, 0, 1, 1, 1, 1, '{}', 4),
	(48, 6, 'body', 'rich_text_box', 'Body', 0, 0, 1, 1, 1, 1, '{}', 5),
	(49, 6, 'slug', 'text', 'Slug', 1, 1, 1, 1, 1, 1, '{"slugify":{"origin":"title"},"validation":{"rule":"unique:pages,slug"}}', 6),
	(50, 6, 'meta_description', 'text', 'Meta Description', 0, 0, 1, 1, 1, 1, '{}', 7),
	(51, 6, 'meta_keywords', 'text', 'Meta Keywords', 0, 0, 1, 1, 1, 1, '{}', 8),
	(52, 6, 'status', 'select_dropdown', 'Status', 1, 1, 1, 1, 1, 1, '{"default":"INACTIVE","options":{"INACTIVE":"INACTIVE","ACTIVE":"ACTIVE"}}', 9),
	(53, 6, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 0, 0, 0, '{}', 10),
	(54, 6, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 11),
	(55, 6, 'image', 'image', 'Page Image', 0, 0, 0, 0, 0, 0, '{}', 12),
	(56, 9, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
	(57, 9, 'shop_id', 'text', 'Shop Id', 1, 1, 1, 1, 1, 1, '{"display":{"width":"6"},"validation":{"rule":"required"}}', 5),
	(58, 9, 'name', 'text', 'Offer Title', 0, 1, 1, 1, 1, 1, '{"display":{"width":"6"},"validation":{"rule":"required"}}', 6),
	(59, 9, 'slug', 'text', 'Slug', 0, 1, 1, 1, 1, 1, '{"slugify":{"origin":"name"},"display":{"width":"6"},"validation":{"rule":"required"}}', 7),
	(60, 9, 'type', 'text', 'Type', 0, 0, 0, 0, 0, 0, '{"display":{"width":"6"},"validation":{"rule":"required"}}', 8),
	(61, 9, 'status', 'select_dropdown', 'Status', 1, 0, 0, 0, 0, 0, '{"display":{"width":"3"},"default":"Active","options":{"0":"Inactive","1":"Active"}}', 16),
	(62, 9, 'featured', 'select_dropdown', 'Featured', 1, 1, 1, 1, 1, 1, '{"display":{"width":"6"},"default":"Off","options":{"0":"Off","1":"On"}}', 9),
	(63, 9, 'description', 'rich_text_box', 'Description', 0, 0, 1, 1, 1, 1, '{"display":{"width":"6"},"validation":{"rule":"required"}}', 10),
	(64, 9, 'short_description', 'rich_text_box', 'Short Description', 0, 0, 1, 1, 1, 1, '{"display":{"width":"6"},"validation":{"rule":"required"}}', 11),
	(65, 9, 'sku', 'text', 'Sku', 0, 0, 0, 0, 0, 0, '{"display":{"width":"6"}}', 12),
	(66, 9, 'price', 'text', 'Price', 0, 1, 1, 1, 1, 1, '{"display":{"width":"6"},"validation":{"rule":"required"}}', 18),
	(67, 9, 'sale_price', 'text', 'Sale Price', 0, 0, 0, 0, 0, 0, '{"display":{"width":"6"}}', 19),
	(68, 9, 'total_sale', 'text', 'Total Sale', 0, 0, 1, 0, 0, 1, '{}', 22),
	(69, 9, 'downloads', 'text', 'Downloads', 0, 0, 1, 0, 0, 1, '{}', 23),
	(70, 9, 'manage_stock', 'text', 'Manage Stock', 1, 0, 0, 0, 0, 0, '{"display":{"width":"6"}}', 25),
	(71, 9, 'quantity', 'text', 'Quantity', 0, 1, 1, 1, 1, 1, '{"display":{"width":"6"},"validation":{"rule":"required"}}', 13),
	(72, 9, 'weight', 'text', 'Weight', 0, 0, 0, 0, 0, 0, '{"display":{"width":"3"}}', 21),
	(73, 9, 'dimensions', 'text', 'Dimensions', 0, 0, 1, 0, 0, 0, '{"display":{"width":"3"}}', 24),
	(74, 9, 'rating_count', 'text', 'Rating Count', 0, 0, 0, 0, 0, 0, '{"display":{"width":"6"}}', 26),
	(75, 9, 'parent_id', 'text', 'Parent Id', 0, 0, 0, 0, 0, 0, '{"default":"","null":"","options":{"":"-- None --"},"relationship":{"key":"id","label":"name"},"display":{"width":"3"}}', 27),
	(76, 9, 'image', 'image', 'Image', 0, 1, 1, 1, 1, 1, '{"display":{"width":"6"}}', 28),
	(77, 9, 'images', 'multiple_images', 'Images', 0, 0, 1, 1, 1, 1, '{"display":{"width":"6"},"default":"Active","options":{"0":"Inactive","1":"Active"}}', 29),
	(78, 9, 'variations', 'text', 'Variations', 0, 0, 0, 0, 0, 0, '{"display":{"width":"6"}}', 30),
	(79, 9, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 0, 0, 1, '{}', 32),
	(80, 9, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 34),
	(81, 9, 'product_belongsto_shop_relationship', 'relationship', 'shops', 0, 1, 1, 1, 1, 1, '{"display":{"width":"6"},"model":"App\\\\Models\\\\Shop","table":"shops","type":"belongsTo","column":"shop_id","key":"id","label":"name","pivot_table":"addresses","pivot":"0","taggable":"0"}', 2),
	(82, 9, 'product_belongsto_product_relationship', 'relationship', 'Parent', 0, 0, 0, 0, 0, 1, '{"display":{"width":"6"},"model":"App\\\\Models\\\\Product","table":"products","type":"belongsTo","column":"parent_id","key":"id","label":"name","pivot_table":"addresses","pivot":"0","taggable":"0"}', 3),
	(83, 11, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
	(84, 11, 'user_id', 'text', 'User Id', 0, 0, 0, 0, 0, 0, '{}', 2),
	(85, 11, 'code', 'text', 'Code', 1, 1, 1, 1, 1, 1, '{"display":{"width":"6"}}', 4),
	(86, 11, 'discount', 'number', 'Discount', 1, 1, 1, 1, 1, 1, '{"display":{"width":"6"}}', 5),
	(87, 11, 'expire_at', 'date', 'Expire At', 1, 1, 1, 1, 1, 1, '{"display":{"width":"6"}}', 6),
	(88, 11, 'limit', 'number', 'Limit', 1, 1, 1, 1, 1, 1, '{"display":{"width":"6"}}', 7),
	(89, 11, 'minimum_cart', 'number', 'Minimum Cart', 1, 1, 1, 1, 1, 1, '{"display":{"width":"6"}}', 8),
	(90, 11, 'used', 'text', 'Used', 0, 0, 1, 1, 0, 1, '{}', 9),
	(91, 11, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 10),
	(92, 11, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 11),
	(94, 11, 'coupon_belongsto_user_relationship', 'relationship', 'users', 0, 0, 0, 0, 0, 1, '{"model":"App\\\\Models\\\\User","table":"users","type":"belongsTo","column":"user_id","key":"id","label":"name","pivot_table":"addresses","pivot":"0","taggable":"0"}', 12),
	(95, 13, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
	(96, 13, 'user_id', 'text', 'User Id', 1, 1, 1, 1, 1, 1, '{}', 3),
	(99, 13, 'company', 'text', 'Company', 0, 0, 1, 1, 1, 1, '{"display":{"width":"6"}}', 6),
	(100, 13, 'address_1', 'text_area', 'Address 1', 1, 0, 1, 1, 1, 1, '{"display":{"width":"6"}}', 7),
	(101, 13, 'address_2', 'text_area', 'Address 2', 0, 0, 1, 1, 1, 1, '{"display":{"width":"6"}}', 8),
	(102, 13, 'city', 'text', 'City', 1, 0, 1, 1, 1, 1, '{"display":{"width":"6"}}', 9),
	(103, 13, 'state', 'text', 'State', 0, 0, 1, 1, 1, 1, '{"display":{"width":"6"}}', 10),
	(104, 13, 'post_code', 'text', 'Post Code', 1, 1, 1, 1, 1, 1, '{"display":{"width":"6"}}', 11),
	(105, 13, 'country', 'text', 'Country', 1, 0, 1, 1, 1, 1, '{"display":{"width":"6"}}', 12),
	(107, 13, 'phone', 'text', 'Phone', 1, 1, 1, 1, 1, 1, '{"display":{"width":"6"}}', 14),
	(108, 13, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 15),
	(109, 13, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 16),
	(110, 13, 'address_belongsto_user_relationship', 'relationship', 'users', 0, 1, 1, 1, 1, 1, '{"display":{"width":"6"},"model":"App\\\\Models\\\\User","table":"users","type":"belongsTo","column":"user_id","key":"id","label":"name","pivot_table":"addresses","pivot":"0","taggable":"0"}', 2),
	(111, 14, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
	(112, 14, 'shop_id', 'text', 'Shop Id', 1, 0, 0, 0, 0, 0, '{}', 3),
	(113, 14, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, '{"display":{"width":"6"},"validation":{"rule":"required"}}', 4),
	(114, 14, 'logo', 'image', 'Logo', 1, 1, 1, 1, 1, 1, '{"display":{"width":"6"}}', 5),
	(115, 14, 'slug', 'text', 'Slug', 1, 1, 1, 1, 1, 1, '{"display":{"width":"6"},"slugify":{"origin":"name"},"validation":{"rule":"required"}}', 6),
	(116, 14, 'parent_id', 'text', 'Parent Id', 0, 1, 1, 1, 1, 1, '{}', 7),
	(117, 14, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 8),
	(118, 14, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 9),
	(119, 14, 'prodcat_belongsto_prodcat_relationship', 'relationship', 'Parent', 0, 1, 1, 1, 1, 1, '{"display":{"width":"6"},"model":"App\\\\Models\\\\Prodcat","table":"prodcats","type":"belongsTo","column":"parent_id","key":"id","label":"name","pivot_table":"addresses","pivot":"0","taggable":"0"}', 2),
	(120, 16, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
	(121, 16, 'product_id', 'text', 'Product Id', 1, 1, 1, 1, 1, 1, '{}', 2),
	(122, 16, 'status', 'select_dropdown', 'Status', 1, 1, 1, 1, 1, 1, '{"default":"Active","options":{"0":"Inactive","1":"Active"}}', 3),
	(123, 16, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, '{}', 4),
	(124, 16, 'email', 'text', 'Email', 1, 1, 1, 1, 1, 1, '{}', 5),
	(125, 16, 'rating', 'text', 'Rating', 1, 1, 1, 1, 1, 1, '{}', 6),
	(126, 16, 'review', 'text', 'Review', 1, 1, 1, 1, 1, 1, '{}', 7),
	(127, 16, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 8),
	(128, 16, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 9),
	(129, 16, 'rating_belongsto_product_relationship', 'relationship', 'Offer', 0, 1, 1, 1, 1, 1, '{"model":"App\\\\Models\\\\Product","table":"products","type":"belongsTo","column":"product_id","key":"id","label":"name","pivot_table":"addresses","pivot":"0","taggable":"0"}', 10),
	(151, 18, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
	(152, 18, 'user_id', 'text', 'User Id', 0, 1, 1, 1, 1, 1, '{}', 5),
	(153, 18, 'shop_id', 'text', 'Shop Id', 0, 1, 1, 1, 1, 1, '{}', 6),
	(154, 18, 'product_id', 'text', 'Product Id', 0, 1, 1, 1, 1, 1, '{}', 7),
	(155, 18, 'status', 'select_dropdown', 'Status', 1, 1, 1, 1, 1, 1, '{"default":"pending","options":{"0":"pending","1":"paid","2":"on its way","3":"cancle"},"display":{"width":"6"}}', 8),
	(156, 18, 'currency', 'text', 'Currency', 0, 0, 0, 1, 0, 1, '{}', 9),
	(157, 18, 'discount', 'text', 'Discount', 0, 0, 1, 1, 1, 1, '{"display":{"width":"6"}}', 10),
	(158, 18, 'discount_code', 'text', 'Discount Code', 0, 0, 1, 1, 1, 1, '{"display":{"width":"6"}}', 11),
	(159, 18, 'shipping_total', 'text', 'Shipping Total', 0, 0, 1, 1, 1, 1, '{"display":{"width":"6"}}', 12),
	(160, 18, 'shipping_method', 'text', 'Shipping Method', 0, 0, 1, 1, 1, 1, '{"display":{"width":"6"}}', 13),
	(161, 18, 'shipping_url', 'text', 'Shipping Url', 0, 0, 1, 1, 1, 1, '{"display":{"width":"6"}}', 14),
	(162, 18, 'subtotal', 'text', 'Subtotal', 1, 0, 1, 1, 1, 1, '{"display":{"width":"6"}}', 15),
	(163, 18, 'total', 'text', 'Total', 1, 1, 1, 1, 1, 1, '{"display":{"width":"6"}}', 16),
	(164, 18, 'tax', 'text', 'Tax', 0, 0, 1, 1, 1, 1, '{"display":{"width":"6"}}', 17),
	(165, 18, 'customer_note', 'text', 'Customer Note', 0, 0, 1, 1, 1, 1, '{"display":{"width":"6"}}', 18),
	(166, 18, 'billing', 'text', 'Billing', 0, 0, 1, 1, 0, 1, '{}', 19),
	(167, 18, 'shipping', 'text', 'Shipping', 1, 0, 1, 1, 0, 1, '{}', 20),
	(168, 18, 'payment_method', 'text', 'Payment Method', 0, 0, 1, 1, 1, 1, '{"display":{"width":"6"}}', 21),
	(169, 18, 'payment_method_title', 'text', 'Payment Method Title', 0, 0, 1, 1, 1, 1, '{"display":{"width":"6"}}', 22),
	(170, 18, 'transaction_id', 'text', 'Transaction Id', 0, 0, 1, 1, 1, 1, '{"display":{"width":"6"}}', 23),
	(171, 18, 'date_paid', 'timestamp', 'Date Paid', 0, 0, 1, 1, 1, 1, '{"display":{"width":"6"}}', 24),
	(172, 18, 'date_completed', 'timestamp', 'Date Completed', 0, 0, 1, 1, 1, 1, '{"display":{"width":"6"}}', 25),
	(173, 18, 'refund_amount', 'text', 'Refund Amount', 0, 0, 1, 1, 1, 1, '{"display":{"width":"6"}}', 26),
	(174, 18, 'company', 'text', 'Company', 0, 0, 1, 1, 1, 1, '{"display":{"width":"6"}}', 27),
	(175, 18, 'aptment', 'text', 'Aptment', 0, 0, 1, 1, 1, 1, '{"display":{"width":"6"}}', 28),
	(176, 18, 'quantity', 'text', 'Quantity', 1, 1, 1, 1, 1, 1, '{"display":{"width":"6"}}', 29),
	(177, 18, 'parent_id', 'text', 'Parent Id', 0, 0, 1, 1, 1, 1, '{"display":{"width":"6"}}', 30),
	(178, 18, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 31),
	(179, 18, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 32),
	(180, 18, 'order_belongsto_user_relationship', 'relationship', 'users', 0, 1, 1, 1, 1, 1, '{"display":{"width":"6"},"model":"App\\\\Models\\\\User","table":"users","type":"belongsTo","column":"user_id","key":"id","label":"name","pivot_table":"addresses","pivot":"0","taggable":"0"}', 2),
	(181, 18, 'order_belongsto_shop_relationship', 'relationship', 'shops', 0, 1, 1, 1, 1, 1, '{"display":{"width":"6"},"model":"App\\\\Models\\\\Shop","table":"shops","type":"belongsTo","column":"shop_id","key":"id","label":"name","pivot_table":"addresses","pivot":"0","taggable":"0"}', 3),
	(182, 18, 'order_belongsto_product_relationship', 'relationship', 'products', 0, 1, 1, 1, 1, 1, '{"display":{"width":"6"},"model":"App\\\\Models\\\\Product","table":"products","type":"belongsTo","column":"product_id","key":"id","label":"name","pivot_table":"addresses","pivot":"0","taggable":"0"}', 4),
	(183, 19, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
	(184, 19, 'image', 'image', 'Image', 1, 1, 1, 1, 1, 1, '{}', 2),
	(185, 19, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 3),
	(186, 19, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 4),
	(188, 21, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
	(189, 21, 'user_id', 'text', 'User Id', 1, 1, 1, 1, 1, 1, '{}', 2),
	(190, 21, 'phone', 'text', 'Phone', 1, 1, 1, 1, 1, 1, '{}', 3),
	(191, 21, 'dob', 'timestamp', 'Dob', 1, 1, 1, 1, 1, 1, '{}', 4),
	(192, 21, 'tax_no', 'text', 'Tax No', 1, 1, 1, 1, 1, 1, '{}', 5),
	(193, 21, 'card_no', 'text', 'Card No', 1, 1, 1, 1, 1, 1, '{}', 6),
	(194, 21, 'govt_id', 'text', 'Govt Id', 1, 1, 1, 1, 1, 1, '{}', 7),
	(195, 21, 'bank_ac', 'text', 'Bank Ac', 1, 1, 1, 1, 1, 1, '{}', 8),
	(196, 21, 'address', 'text', 'Address', 1, 1, 1, 1, 1, 1, '{}', 9),
	(197, 21, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 10),
	(198, 21, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 11),
	(199, 21, 'verification_belongsto_user_relationship', 'relationship', 'users', 0, 1, 1, 1, 1, 1, '{"model":"App\\\\Models\\\\User","table":"users","type":"belongsTo","column":"user_id","key":"id","label":"name","pivot_table":"addresses","pivot":"0","taggable":null}', 12),
	(200, 9, 'vendor_price', 'text', 'Vendor Price', 0, 0, 0, 0, 0, 0, '{}', 15),
	(201, 9, 'views', 'text', 'Views', 1, 0, 0, 0, 0, 0, '{}', 17),
	(202, 18, 'vendor_total', 'text', 'Vendor Total', 0, 1, 1, 1, 1, 1, '{}', 14),
	(203, 22, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
	(204, 22, 'parent_id', 'text', 'Parent Id', 0, 1, 1, 1, 1, 1, '{}', 4),
	(205, 22, 'shop_id', 'text', 'Shop Id', 1, 1, 1, 1, 1, 1, '{}', 2),
	(206, 22, 'user_id', 'text', 'User Id', 0, 1, 1, 1, 1, 1, '{}', 3),
	(207, 22, 'subject', 'text', 'Subject', 0, 1, 1, 1, 1, 1, '{}', 5),
	(208, 22, 'massage', 'text', 'Massage', 0, 1, 1, 1, 1, 1, '{}', 6),
	(209, 22, 'image', 'image', 'Image', 0, 1, 1, 1, 1, 1, '{}', 7),
	(210, 22, 'status', 'select_dropdown', 'Status', 1, 1, 1, 1, 1, 1, '{"default":"0","options":{"0":"Active","1":"Closed"}}', 8),
	(211, 22, 'action', 'select_dropdown', 'Action', 0, 1, 1, 1, 1, 1, '{"default":"0","options":{"0":"Awaiting response from the customer","1":"Awaiting response from you"}}', 9),
	(212, 22, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{"format":"%m-%d-%Y"}', 10),
	(213, 22, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 11),
	(214, 22, 'ticket_belongsto_shop_relationship', 'relationship', 'shops', 0, 1, 1, 1, 1, 1, '{"model":"App\\\\Models\\\\Shop","table":"shops","type":"belongsTo","column":"shop_id","key":"id","label":"name","pivot_table":"addresses","pivot":"0","taggable":null}', 12),
	(216, 23, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
	(217, 23, 'name', 'text', 'Name', 0, 1, 1, 1, 1, 1, '{}', 2),
	(218, 23, 'slug', 'text', 'Slug', 0, 1, 1, 1, 1, 1, '{"slugify":{"origin":"name"}}', 3),
	(219, 23, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 4),
	(220, 23, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 5),
	(221, 9, 'city_id', 'text', 'City Id', 0, 1, 1, 1, 1, 1, '{}', 4),
	(222, 9, 'amenities', 'text', 'Amenities', 0, 0, 0, 0, 0, 0, '{}', 14),
	(223, 9, 'post_code', 'text', 'Post Code', 0, 0, 0, 0, 0, 0, '{}', 31),
	(224, 9, 'is_offer', 'text', 'Is Offer', 0, 0, 0, 0, 0, 0, '{}', 35),
	(225, 9, 'expired_at', 'timestamp', 'Expired At', 1, 1, 1, 1, 1, 1, '{"display":{"width":"6"}}', 20),
	(226, 9, 'product_belongsto_city_relationship', 'relationship', 'City', 0, 1, 1, 1, 1, 1, '{"display":{"width":"6"},"model":"App\\\\City","table":"cities","type":"belongsTo","column":"city_id","key":"id","label":"name","pivot_table":"addresses","pivot":"0","taggable":"0"}', 36),
	(227, 24, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
	(228, 24, 'user_id', 'text', 'User Id', 0, 0, 0, 0, 0, 0, '{}', 2),
	(229, 24, 'product_id', 'text', 'Product Id', 0, 1, 1, 1, 1, 1, '{}', 3),
	(230, 24, 'shop_id', 'text', 'Shop Id', 0, 1, 1, 1, 1, 1, '{}', 4),
	(231, 24, 'title', 'text', 'Title', 1, 1, 1, 1, 1, 1, '{}', 5),
	(232, 24, 'slug', 'text', 'Slug', 1, 1, 1, 1, 1, 1, '{"slugify":{"origin":"title"}}', 6),
	(233, 24, 'description', 'rich_text_box', 'Description', 0, 1, 1, 1, 1, 1, '{}', 7),
	(234, 24, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 8),
	(235, 24, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 9),
	(236, 24, 'images', 'multiple_images', 'Images', 0, 1, 1, 1, 1, 1, '{}', 10),
	(237, 24, 'expired_at', 'timestamp', 'Expired At', 0, 1, 1, 1, 1, 1, '{}', 11),
	(238, 24, 'featured', 'checkbox', 'Featured', 0, 1, 1, 1, 1, 1, '{"off":"Off","on":"On","checked":true}', 12),
	(239, 24, 'offer_belongsto_product_relationship', 'relationship', 'products', 0, 1, 1, 1, 1, 1, '{"model":"App\\\\Models\\\\Product","table":"products","type":"belongsTo","column":"product_id","key":"id","label":"name","pivot_table":"addresses","pivot":"0","taggable":"0"}', 13),
	(240, 24, 'offer_belongsto_shop_relationship', 'relationship', 'shops', 0, 1, 1, 1, 1, 1, '{"model":"App\\\\Models\\\\Shop","table":"shops","type":"belongsTo","column":"shop_id","key":"id","label":"name","pivot_table":"addresses","pivot":"0","taggable":"0"}', 14),
	(241, 27, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
	(242, 27, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, '{"validation":{"rule":"required"}}', 2),
	(243, 27, 'slug', 'text', 'Slug', 1, 1, 1, 1, 1, 1, '{"slugify":{"origin":"name"},"validation":{"rule":"required"}}', 3),
	(244, 27, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 4),
	(245, 27, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 5),
	(246, 27, 'description', 'text_area', 'Description', 0, 1, 1, 1, 1, 1, '{}', 6),
	(247, 9, 'product_belongstomany_prodcat_relationship', 'relationship', 'Category', 0, 1, 1, 1, 1, 1, '{"display":{"width":"6"},"model":"App\\\\Models\\\\Prodcat","table":"prodcats","type":"belongsToMany","column":"id","key":"id","label":"name","pivot_table":"prodcat_product","pivot":"1","taggable":"on"}', 37),
	(248, 9, 'product_belongstomany_facility_relationship', 'relationship', 'facilities', 0, 1, 1, 1, 1, 1, '{"display":{"width":"6"},"model":"App\\\\Models\\\\Facility","table":"facilities","type":"belongsToMany","column":"id","key":"id","label":"name","pivot_table":"facility_product","pivot":"1","taggable":"on"}', 38),
	(249, 28, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
	(250, 28, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, '{}', 2),
	(251, 28, 'email', 'text', 'Email', 1, 1, 1, 1, 1, 1, '{}', 3),
	(252, 28, 'phone', 'text', 'Phone', 1, 1, 1, 1, 1, 1, '{}', 4),
	(253, 28, 'subject', 'text', 'Subject', 1, 1, 1, 1, 1, 1, '{}', 5),
	(254, 28, 'message', 'text', 'Message', 1, 1, 1, 1, 1, 1, '{}', 6),
	(255, 28, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 7),
	(256, 28, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 8),
	(257, 19, 'title', 'text', 'Title', 0, 1, 1, 1, 1, 1, '{}', 5),
	(258, 19, 'sub_title', 'text', 'Sub Title', 0, 1, 1, 1, 1, 1, '{}', 6),
	(259, 19, 'link', 'text', 'Link', 0, 1, 1, 1, 1, 1, '{}', 7),
	(260, 9, 'bestdeals', 'checkbox', 'Best Deals', 0, 1, 1, 1, 1, 1, '{"on":"On","off":"Off","checked":false,"display":{"width":"6"}}', 33),
	(261, 16, 'user_id', 'text', 'User Id', 1, 0, 0, 0, 0, 0, '{}', 3),
	(262, 16, 'shop_id', 'text', 'Shop Id', 1, 1, 1, 1, 1, 1, '{}', 4),
	(263, 1, 'l_name', 'text', 'Last Name', 0, 1, 1, 1, 1, 1, '{}', 3),
	(264, 1, 'email_verified_at', 'timestamp', 'Email Verified At', 0, 0, 0, 0, 0, 0, '{}', 11),
	(265, 1, 'stripe_id', 'text', 'Stripe Id', 0, 0, 0, 0, 0, 0, '{}', 15),
	(266, 1, 'pm_type', 'text', 'Pm Type', 0, 0, 0, 0, 0, 0, '{}', 16),
	(267, 1, 'pm_last_four', 'text', 'Pm Last Four', 0, 0, 0, 0, 0, 0, '{}', 17),
	(268, 1, 'trial_ends_at', 'timestamp', 'Trial Ends At', 0, 0, 0, 0, 0, 0, '{}', 18),
	(269, 1, 'paid_at', 'text', 'Paid At', 0, 0, 0, 0, 0, 0, '{}', 19),
	(270, 29, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
	(271, 29, 'key', 'text', 'Key', 0, 1, 1, 1, 1, 1, '{}', 2),
	(272, 29, 'english', 'markdown_editor', 'English', 0, 1, 1, 1, 1, 1, '{}', 3),
	(273, 29, 'danish', 'markdown_editor', 'Danish', 0, 1, 1, 1, 1, 1, '{}', 4),
	(274, 29, 'spanish', 'markdown_editor', 'Spanish', 0, 1, 1, 1, 1, 1, '{}', 5),
	(275, 29, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 6),
	(276, 29, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 7),
	(277, 33, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
	(278, 33, 'email', 'text', 'Email', 1, 1, 1, 1, 1, 1, '{}', 2),
	(279, 33, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 3),
	(280, 33, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 4);

-- Dumping structure for table ticket.data_types
CREATE TABLE IF NOT EXISTS `data_types` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name_singular` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name_plural` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `policy_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `controller` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `generate_permissions` tinyint(1) NOT NULL DEFAULT '0',
  `server_side` tinyint NOT NULL DEFAULT '0',
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `data_types_name_unique` (`name`),
  UNIQUE KEY `data_types_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.data_types: ~21 rows (approximately)
INSERT INTO `data_types` (`id`, `name`, `slug`, `display_name_singular`, `display_name_plural`, `icon`, `model_name`, `policy_name`, `controller`, `description`, `generate_permissions`, `server_side`, `details`, `created_at`, `updated_at`) VALUES
	(1, 'users', 'users', 'User', 'Users', 'voyager-person', 'TCG\\Voyager\\Models\\User', 'TCG\\Voyager\\Policies\\UserPolicy', 'TCG\\Voyager\\Http\\Controllers\\VoyagerUserController', NULL, 1, 1, '{"order_column":null,"order_display_column":null,"order_direction":"desc","default_search_key":null,"scope":null}', '2023-03-12 01:03:40', '2023-10-31 05:46:50'),
	(2, 'menus', 'menus', 'Menu', 'Menus', 'voyager-list', 'TCG\\Voyager\\Models\\Menu', NULL, '', '', 1, 0, NULL, '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
	(3, 'roles', 'roles', 'Role', 'Roles', 'voyager-lock', 'TCG\\Voyager\\Models\\Role', NULL, 'TCG\\Voyager\\Http\\Controllers\\VoyagerRoleController', '', 1, 0, NULL, '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
	(4, 'categories', 'categories', 'Category', 'Categories', 'voyager-categories', 'TCG\\Voyager\\Models\\Category', NULL, '', '', 1, 0, NULL, '2023-03-12 01:03:41', '2023-03-12 01:03:41'),
	(5, 'posts', 'posts', 'Post', 'Posts', 'voyager-news', 'TCG\\Voyager\\Models\\Post', 'TCG\\Voyager\\Policies\\PostPolicy', NULL, NULL, 1, 0, '{"order_column":null,"order_display_column":null,"order_direction":"desc","default_search_key":null,"scope":null}', '2023-03-12 01:03:41', '2023-11-02 12:16:44'),
	(6, 'pages', 'pages', 'Page', 'Pages', 'voyager-file-text', 'TCG\\Voyager\\Models\\Page', NULL, NULL, NULL, 1, 0, '{"order_column":null,"order_display_column":null,"order_direction":"desc","default_search_key":null,"scope":null}', '2023-03-12 01:03:41', '2023-11-01 14:27:57'),
	(9, 'products', 'products', 'Offer', 'Offers', 'voyager-shop', 'App\\Models\\Product', NULL, NULL, NULL, 1, 0, '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":null}', '2023-04-07 11:28:10', '2023-11-13 09:18:18'),
	(11, 'coupons', 'coupons', 'Coupon', 'Coupons', 'voyager-ticket', 'App\\Models\\Coupon', NULL, NULL, NULL, 1, 0, '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":null}', '2023-04-07 12:15:49', '2023-04-07 12:23:29'),
	(13, 'addresses', 'addresses', 'Address', 'Addresses', 'voyager-location', 'App\\Models\\Address', NULL, NULL, NULL, 0, 0, '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":null}', '2023-04-07 12:26:46', '2023-09-11 23:29:30'),
	(14, 'prodcats', 'prodcats', 'Offer Category', 'Offer categories', 'voyager-company', 'App\\Models\\Prodcat', NULL, NULL, NULL, 1, 0, '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":null}', '2023-04-07 12:36:57', '2023-10-04 08:43:54'),
	(16, 'ratings', 'ratings', 'Rating', 'Ratings', 'voyager-star-two', 'App\\Models\\Rating', NULL, NULL, NULL, 1, 0, '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":null}', '2023-04-07 12:44:56', '2023-10-04 08:54:41'),
	(18, 'orders', 'orders', 'Order', 'Orders', 'voyager-basket', 'App\\Models\\Order', NULL, NULL, NULL, 1, 0, '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":null}', '2023-04-08 09:32:52', '2023-05-04 11:59:46'),
	(19, 'sliders', 'sliders', 'Slider', 'Sliders', 'voyager-images', 'App\\Slider', NULL, NULL, NULL, 1, 0, '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":null}', '2023-04-11 11:40:00', '2023-09-26 16:36:19'),
	(21, 'verifications', 'verifications', 'Verification', 'Verifications', 'voyager-bookmark', 'App\\Models\\Verification', NULL, NULL, NULL, 1, 0, '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null}', '2023-05-04 11:43:33', '2023-05-04 11:43:33'),
	(22, 'tickets', 'tickets', 'Ticket', 'Tickets', 'voyager-ticket', 'App\\Models\\Ticket', NULL, NULL, NULL, 1, 0, '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":"parents"}', '2023-05-11 00:40:41', '2023-05-11 00:48:59'),
	(23, 'cities', 'cities', 'City', 'Cities', 'voyager-list-add', 'App\\City', NULL, NULL, NULL, 1, 0, '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null}', '2023-09-19 04:28:13', '2023-09-19 04:28:13'),
	(24, 'offers', 'offers', 'Offer', 'Offers', 'voyager-receipt', 'App\\Models\\Offer', NULL, NULL, NULL, 1, 0, '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":null}', '2023-09-24 13:36:16', '2023-09-24 13:43:40'),
	(27, 'facilities', 'facilities', 'Facility', 'Facilities', 'voyager-news', 'App\\Models\\Facility', NULL, NULL, NULL, 1, 0, '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":null}', '2023-09-25 16:44:21', '2023-09-25 16:47:02'),
	(28, 'contacts', 'contacts', 'Contact', 'Contacts', 'voyager-logbook', 'App\\Models\\Contact', NULL, NULL, NULL, 1, 0, '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null}', '2023-09-26 10:56:10', '2023-09-26 10:56:10'),
	(29, 'languages', 'languages', 'Language', 'Languages', 'voyager-book', 'App\\Models\\Language', NULL, NULL, NULL, 1, 0, '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":null}', '2023-11-03 21:26:39', '2023-11-04 12:13:51'),
	(33, 'emails', 'emails', 'Email', 'Emails', 'voyager-mail', 'App\\Models\\Email', NULL, NULL, NULL, 1, 0, '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null}', '2024-03-31 14:26:21', '2024-03-31 14:26:21');

-- Dumping structure for table ticket.emails
CREATE TABLE IF NOT EXISTS `emails` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `emails_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.emails: ~3 rows (approximately)
INSERT INTO `emails` (`id`, `email`, `created_at`, `updated_at`) VALUES
	(1, 'lilikasi@mailinator.com', '2024-03-31 14:18:15', '2024-03-31 14:18:15'),
	(2, 'sulligee786@gmail.com', '2024-04-16 18:07:21', '2024-04-16 18:07:21'),
	(3, 'sulligees@gmail.com', '2024-07-07 10:42:53', '2024-07-07 10:42:53');

-- Dumping structure for table ticket.facilities
CREATE TABLE IF NOT EXISTS `facilities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.facilities: ~8 rows (approximately)
INSERT INTO `facilities` (`id`, `name`, `slug`, `created_at`, `updated_at`, `description`) VALUES
	(1, '1-2 Personer', '1-2 personer', '2023-09-25 00:22:00', '2023-10-07 21:53:31', NULL),
	(2, 'Free Wifi', 'free-wifi', '2023-09-25 00:23:00', '2023-09-25 00:48:51', 'test test'),
	(3, 'Gratis parkering', 'gratis-parkering', '2023-09-26 17:06:07', '2023-09-26 17:06:07', NULL),
	(4, '100 % Halal', '100-halal', '2023-10-02 15:32:49', '2023-10-02 15:32:49', NULL),
	(5, 'Delvis halal', 'delvis-halal', '2023-10-02 15:33:05', '2023-10-02 15:33:05', NULL),
	(6, 'Kun for kvinder', 'kun-for-kvinder', '2023-10-02 15:33:58', '2023-10-02 15:33:58', NULL),
	(7, 'Familie orienteret', 'familie-orienteret', '2023-10-07 21:53:50', '2023-10-07 21:53:50', NULL),
	(8, 'Bedste pris', 'Bedste-pris', '2023-10-23 16:55:00', '2023-10-26 11:05:19', NULL);

-- Dumping structure for table ticket.facility_product
CREATE TABLE IF NOT EXISTS `facility_product` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `facility_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `facility_products_facility_id_foreign` (`facility_id`),
  KEY `facility_products_product_id_foreign` (`product_id`),
  CONSTRAINT `facility_products_facility_id_foreign` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`) ON DELETE CASCADE,
  CONSTRAINT `facility_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.facility_product: ~18 rows (approximately)
INSERT INTO `facility_product` (`id`, `facility_id`, `product_id`, `created_at`, `updated_at`) VALUES
	(5, 1, 67, NULL, NULL),
	(6, 2, 67, NULL, NULL),
	(7, 3, 67, NULL, NULL),
	(8, 5, 67, NULL, NULL),
	(9, 1, 71, NULL, NULL),
	(10, 2, 71, NULL, NULL),
	(11, 5, 71, NULL, NULL),
	(12, 2, 72, NULL, NULL),
	(13, 3, 72, NULL, NULL),
	(14, 1, 74, NULL, NULL),
	(15, 2, 74, NULL, NULL),
	(16, 5, 74, NULL, NULL),
	(17, 1, 75, NULL, NULL),
	(18, 2, 75, NULL, NULL),
	(19, 3, 75, NULL, NULL),
	(20, 4, 75, NULL, NULL),
	(21, 2, 76, NULL, NULL),
	(22, 3, 76, NULL, NULL);

-- Dumping structure for table ticket.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table ticket.feedback
CREATE TABLE IF NOT EXISTS `feedback` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `shop_id` bigint unsigned NOT NULL,
  `feedback` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `feedback_order_id_foreign` (`order_id`),
  KEY `feedback_shop_id_foreign` (`shop_id`),
  CONSTRAINT `feedback_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `feedback_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.feedback: ~0 rows (approximately)

-- Dumping structure for table ticket.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.jobs: ~0 rows (approximately)

-- Dumping structure for table ticket.languages
CREATE TABLE IF NOT EXISTS `languages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `english` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `danish` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `spanish` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.languages: ~85 rows (approximately)
INSERT INTO `languages` (`id`, `key`, `english`, `danish`, `spanish`, `created_at`, `updated_at`) VALUES
	(1, 'hello', 'Hello', 'Hej', 'Hola', '2023-11-02 13:17:13', '2023-11-02 13:17:13'),
	(2, 'home', 'Home', 'hjem', 'home', '2023-11-02 14:19:00', '2023-11-02 14:24:25'),
	(3, 'deals', 'deals', 'Tilbud', NULL, '2023-11-02 14:29:20', '2023-11-02 14:29:20'),
	(6, 'slider_btn', 'Button Text', 'Læs mere her', 'Button Text', '2023-11-04 12:14:00', '2023-11-12 17:49:14'),
	(7, 'offer_btn', 'Offer Text', 'Læs mere her...', 'Offer Text', '2023-11-04 12:20:00', '2023-11-12 01:39:57'),
	(8, 'Button text', NULL, 'Se vores daglige deals her', NULL, '2023-11-09 22:50:38', '2023-11-09 22:50:38'),
	(9, 'feature_sec_title', NULL, 'Her er et udpluk af vores tilbud.', NULL, '2023-11-12 20:29:19', '2023-11-12 20:29:19'),
	(10, 'feature_sec_subtittle', NULL, 'Unikke oplevelser finder du her.', NULL, '2023-11-12 20:30:00', '2023-11-12 20:51:26'),
	(11, 'cart_details', NULL, 'Læs mere her', NULL, '2023-11-12 20:35:45', '2023-11-12 20:35:45'),
	(12, 'about', NULL, 'Om', NULL, '2023-11-12 20:44:00', '2023-11-12 20:46:26'),
	(13, 'news', NULL, 'Læs mere om Halaldeals.dk', NULL, '2023-11-12 20:47:30', '2023-11-12 20:47:30'),
	(14, 'contact', NULL, 'Kontakt os', NULL, '2023-11-12 20:49:00', '2023-11-12 20:52:07'),
	(15, 'video_sec_subtittle', NULL, 'Introvideo', NULL, '2023-11-12 21:07:13', '2023-11-12 21:07:13'),
	(16, 'facilities_sec_subtittle', NULL, 'For at gøre det nemt og overskueligt, tilføjer vi disse anmærkninger så det bliver nemmere at vælge.', NULL, '2023-11-12 21:11:00', '2023-11-12 21:11:37'),
	(17, 'facilities_sec_tittle', NULL, 'Anmærkninger', NULL, '2023-11-12 21:12:47', '2023-11-12 21:12:47'),
	(18, 'video_sec_tittle', NULL, 'Se vores introvideo her', NULL, '2023-11-12 21:13:30', '2023-11-12 21:13:30'),
	(19, 'testimonials_sec_tittle', NULL, 'Hvad siger vores kunder', NULL, '2023-11-12 21:14:13', '2023-11-12 21:14:13'),
	(20, 'testimonials_sec_subtittle', NULL, 'Anmeldelser', NULL, '2023-11-12 21:15:09', '2023-11-12 21:15:09'),
	(21, 'explore', NULL, 'Menu', NULL, '2023-11-12 21:15:34', '2023-11-12 21:15:34'),
	(22, 'contact_us', NULL, 'Kontakt os her', NULL, '2023-11-12 21:15:57', '2023-11-12 21:15:57'),
	(23, 'remove_btn', NULL, 'Filter', NULL, '2023-11-12 21:16:54', '2023-11-12 21:16:54'),
	(24, 'categories', NULL, 'Kategorier', NULL, '2023-11-12 21:17:12', '2023-11-12 21:17:12'),
	(25, 'cities', NULL, 'Byer', NULL, '2023-11-12 21:17:27', '2023-11-12 21:17:27'),
	(26, 'sort_by:', NULL, 'Sorter efter:', NULL, '2023-11-12 21:17:00', '2023-11-12 21:18:35'),
	(27, 'select', NULL, 'Vælg', NULL, '2023-11-12 21:18:12', '2023-11-12 21:18:12'),
	(28, 'expired_date', NULL, 'Udløbsdato', NULL, '2023-11-12 21:19:22', '2023-11-12 21:19:22'),
	(29, 'running', NULL, 'Aktive', NULL, '2023-11-12 21:19:43', '2023-11-12 21:19:43'),
	(30, 'already_expired', NULL, 'Udløbet', NULL, '2023-11-12 21:20:19', '2023-11-12 21:20:19'),
	(31, 'Days_left', NULL, 'dage tilbage', NULL, '2023-11-12 21:20:40', '2023-11-12 21:20:40'),
	(32, 'news_hero_subtittle', NULL, 'Artikler og nyheder', NULL, '2023-11-12 21:22:43', '2023-11-12 21:22:43'),
	(33, 'news_hero_tittle', NULL, 'Nyd vores artikler og opslag om forskellige emner', NULL, '2023-11-12 21:24:13', '2023-11-12 21:24:13'),
	(34, 'contact_hero_subtittle', NULL, 'Kontakt side', NULL, '2023-11-12 21:25:08', '2023-11-12 21:25:08'),
	(35, 'contact_hero_tittle', NULL, 'Kontakt os her og vi vil vende tilbage hurtigst muligt.', NULL, '2023-11-12 21:25:49', '2023-11-12 21:25:49'),
	(36, 'contact_reservation', NULL, 'Kontakt nummer', NULL, '2023-11-12 21:26:11', '2023-11-12 21:26:11'),
	(37, 'contact_email_info', NULL, 'Kontakt os via mail', NULL, '2023-11-12 21:26:40', '2023-11-12 21:26:40'),
	(38, 'contact_sec_tittle', NULL, 'Kontaktformular', NULL, '2023-11-12 21:27:07', '2023-11-12 21:27:07'),
	(39, 'contact_name', NULL, 'Navn', NULL, '2023-11-12 21:27:39', '2023-11-12 21:27:39'),
	(40, 'contact_email', NULL, 'Email', NULL, '2023-11-12 21:27:54', '2023-11-12 21:27:54'),
	(41, 'contact_number', NULL, 'Telefonnummer', NULL, '2023-11-12 21:28:20', '2023-11-12 21:28:20'),
	(42, 'contact_subject', NULL, 'Emne', NULL, '2023-11-12 21:28:00', '2023-11-12 21:28:54'),
	(43, 'contact_message', NULL, 'Besked', NULL, '2023-11-12 21:29:09', '2023-11-12 21:29:09'),
	(44, 'expired_at', NULL, 'Udløber den', NULL, '2023-11-12 21:30:12', '2023-11-12 21:30:12'),
	(45, 'add_to_cart_btn', NULL, 'Tilføj til kurv', NULL, '2023-11-12 21:30:44', '2023-11-12 21:30:44'),
	(46, 'amenities', NULL, 'Faciliteter', NULL, '2023-11-12 21:31:40', '2023-11-12 21:31:40'),
	(47, 'price', NULL, 'Pris', NULL, '2023-11-12 21:32:04', '2023-11-12 21:32:04'),
	(48, 'similar_sec_subtittle', NULL, 'Andre spændende tilbud', NULL, '2023-11-12 21:33:00', '2023-11-12 21:34:02'),
	(49, 'similar_sec_tittle', NULL, 'Et mindre udpluk af andre tilbud finder du her:', NULL, '2023-11-12 21:33:37', '2023-11-12 21:33:37'),
	(50, 'items in your cart', NULL, 'Tilbud i din kurv', NULL, '2023-11-12 21:35:19', '2023-11-12 21:35:19'),
	(51, 'items', NULL, 'Tilbud', NULL, '2023-11-12 21:35:39', '2023-11-12 21:35:39'),
	(52, 'coupon discount', NULL, 'Rabatkode', NULL, '2023-11-12 21:35:57', '2023-11-12 21:35:57'),
	(53, 'apply coupon', NULL, 'Tilføj kode', NULL, '2023-11-12 21:36:17', '2023-11-12 21:36:17'),
	(54, 'total amount', NULL, 'Total beløb', NULL, '2023-11-12 21:36:35', '2023-11-12 21:36:35'),
	(55, 'proceed to checkout', NULL, 'Fortsæt til betaling', NULL, '2023-11-12 21:37:02', '2023-11-12 21:37:02'),
	(56, 'personel_info', NULL, 'Dine informationer', NULL, '2023-11-12 21:37:58', '2023-11-12 21:37:58'),
	(57, 'order_summary', NULL, 'Samlet ordre', NULL, '2023-11-12 21:38:30', '2023-11-12 21:38:30'),
	(58, 'Tax:', NULL, 'Moms:', NULL, '2023-11-12 21:38:56', '2023-11-12 21:38:56'),
	(59, 'order total', NULL, 'Total', NULL, '2023-11-12 21:39:15', '2023-11-12 21:39:15'),
	(60, 'i have read and agree to the terms and conditions of halad deals', NULL, 'Jeg har læst og accepterer handelsbetingelserne for Halaldeals.dk', NULL, '2023-11-12 21:40:14', '2023-11-12 21:40:14'),
	(61, 'place order', NULL, 'Gå til betaling', NULL, '2023-11-12 21:40:50', '2023-11-12 21:40:50'),
	(62, 'register', NULL, 'Opret bruger', NULL, '2023-11-15 15:44:31', '2023-11-15 15:44:31'),
	(63, 'already expired', NULL, 'Udløbet', NULL, '2023-12-03 16:19:49', '2023-12-03 16:19:49'),
	(64, 'tax', NULL, 'Moms', NULL, '2024-03-23 14:58:10', '2024-03-23 14:58:10'),
	(65, 'personal_info', NULL, 'Dine oplysninger', NULL, '2024-03-23 14:58:00', '2024-03-23 14:59:09'),
	(66, 'last_name', NULL, 'Efternavn', NULL, '2024-03-23 14:59:35', '2024-03-23 14:59:35'),
	(67, 'order_summery', NULL, 'Din ordre', NULL, '2024-03-23 15:00:10', '2024-03-23 15:00:10'),
	(68, 'order_total', NULL, 'Samlet ordre', NULL, '2024-03-23 15:00:35', '2024-03-23 15:00:35'),
	(69, 'terms', NULL, 'Accepterer Halaldeals handelsbetingelser', NULL, '2024-03-23 15:01:19', '2024-03-23 15:01:19'),
	(70, 'place_order_btn', NULL, 'Læg ordre', NULL, '2024-03-23 15:02:17', '2024-03-23 15:02:17'),
	(71, 'checkout_cart_footer', NULL, 'Læg ordren og fortsæt til betaling', NULL, '2024-03-23 15:04:07', '2024-03-23 15:04:07'),
	(72, 'learn_more', NULL, 'Læs mere', NULL, '2024-03-23 15:04:37', '2024-03-23 15:04:37'),
	(73, 'last name skal udfyldes', NULL, 'Efternavn mangler', NULL, '2024-03-23 15:05:00', '2024-03-23 15:06:13'),
	(74, 'dashboard', NULL, 'Kontrolpanel', NULL, '2024-03-23 15:08:56', '2024-03-23 15:08:56'),
	(75, 'logout', NULL, 'Logout', NULL, '2024-03-23 15:09:00', '2024-03-23 15:09:53'),
	(76, 'send_message_btn', NULL, 'Send', NULL, '2024-03-23 15:10:35', '2024-03-23 15:10:35'),
	(77, 'recent_posts', NULL, 'Nyheder', NULL, '2024-03-23 15:22:13', '2024-03-23 15:22:13'),
	(78, 'type_here', NULL, 'Søg her', NULL, '2024-03-23 15:22:36', '2024-03-23 15:22:36'),
	(79, 'days_left', NULL, 'dage tilbage', NULL, '2024-03-23 16:07:00', '2024-03-23 16:09:48'),
	(80, 'view more', NULL, 'Se flere tilbud', NULL, '2024-03-23 16:07:54', '2024-03-23 16:07:54'),
	(81, 'sort_by:', NULL, 'Sorter efter:', NULL, '2024-03-23 16:08:00', '2024-03-23 16:08:44'),
	(82, 'total amount', NULL, 'Total beløb', NULL, '2024-03-23 16:11:00', '2024-03-23 16:12:26'),
	(83, 'update', NULL, 'Opdater', NULL, '2024-03-23 16:43:44', '2024-03-23 16:43:44'),
	(84, 'items in your cart', NULL, 'tilbud tilføjet til din kurv', NULL, '2024-03-23 16:44:34', '2024-03-23 16:44:34'),
	(85, 'already expired', NULL, 'Udløbet', NULL, '2024-03-28 11:55:44', '2024-03-28 11:55:44'),
	(86, 'newslater', NULL, 'Nyhedsbrev', NULL, '2024-04-04 18:39:27', '2024-04-04 18:39:27'),
	(87, 'words.phone', NULL, 'Telefon', NULL, '2024-04-30 15:29:09', '2024-04-30 15:29:09');

-- Dumping structure for table ticket.massages
CREATE TABLE IF NOT EXISTS `massages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `sender_id` bigint NOT NULL,
  `reciver_id` bigint NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `massage` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `massages_shop_id_foreign` (`shop_id`),
  KEY `massages_user_id_foreign` (`user_id`),
  CONSTRAINT `massages_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE,
  CONSTRAINT `massages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.massages: ~0 rows (approximately)

-- Dumping structure for table ticket.menus
CREATE TABLE IF NOT EXISTS `menus` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `menus_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.menus: ~2 rows (approximately)
INSERT INTO `menus` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'admin', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
	(3, 'main', '2023-05-03 15:21:32', '2023-05-03 15:21:32');

-- Dumping structure for table ticket.menu_items
CREATE TABLE IF NOT EXISTS `menu_items` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` int unsigned DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `target` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '_self',
  `icon_class` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int DEFAULT NULL,
  `order` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `route` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameters` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `menu_items_menu_id_foreign` (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.menu_items: ~34 rows (approximately)
INSERT INTO `menu_items` (`id`, `menu_id`, `title`, `url`, `target`, `icon_class`, `color`, `parent_id`, `order`, `created_at`, `updated_at`, `route`, `parameters`) VALUES
	(1, 1, 'Dashboard', '', '_self', 'voyager-boat', NULL, NULL, 1, '2023-03-12 01:03:40', '2023-03-12 01:03:40', 'voyager.dashboard', NULL),
	(3, 1, 'Users', '', '_self', 'voyager-person', NULL, 20, 1, '2023-03-12 01:03:40', '2023-04-07 12:58:19', 'voyager.users.index', NULL),
	(8, 1, 'Compass', '', '_self', 'voyager-compass', NULL, 5, 3, '2023-03-12 01:03:40', '2023-04-07 12:32:34', 'voyager.compass.index', NULL),
	(14, 1, 'Offers', '', '_self', 'voyager-shop', '#000000', 24, 4, '2023-04-07 11:28:10', '2023-10-05 06:00:55', 'voyager.products.index', 'null'),
	(15, 1, 'Coupons', '', '_self', 'voyager-ticket', NULL, 28, 6, '2023-04-07 12:15:49', '2023-10-05 06:00:46', 'voyager.coupons.index', NULL),
	(17, 1, 'Offer category', 'admin/prodcats', '_self', 'voyager-company', '#000000', 24, 3, '2023-04-07 12:36:57', '2023-10-06 14:55:22', NULL, ''),
	(18, 1, 'Ratings', '', '_self', 'voyager-star-two', NULL, NULL, 5, '2023-04-07 12:44:57', '2023-11-02 12:50:08', 'voyager.ratings.index', NULL),
	(19, 1, 'Vendors', 'admin/shops', '_self', 'voyager-company', '#000000', 20, 2, '2023-04-07 12:55:50', '2023-11-01 15:06:18', NULL, ''),
	(20, 1, 'Users', '', '_self', 'voyager-people', '#000000', NULL, 2, '2023-04-07 12:58:08', '2023-10-05 06:00:46', NULL, ''),
	(21, 1, 'Orders', '', '_self', 'voyager-basket', NULL, 33, 1, '2023-04-08 09:32:52', '2023-08-09 01:40:46', 'voyager.orders.index', NULL),
	(23, 1, 'Sliders', 'admin/sliders', '_self', 'voyager-images', '#000000', 28, 4, '2023-04-12 09:03:22', '2023-09-21 17:06:19', NULL, ''),
	(24, 1, 'Offers', '', '_self', 'voyager-basket', '#000000', NULL, 3, '2023-04-12 09:15:49', '2023-10-05 06:00:46', NULL, ''),
	(25, 1, 'Settings', 'admin/settings', '_self', 'voyager-settings', '#000000', 28, 1, '2023-04-12 09:17:03', '2023-05-03 15:26:00', NULL, ''),
	(26, 1, 'Pages', 'admin/pages', '_self', 'voyager-file-text', '#000000', 28, 2, '2023-05-03 15:23:47', '2023-05-03 15:26:02', NULL, ''),
	(27, 1, 'Menus', 'admin/menus', '_self', 'voyager-list', '#000000', 28, 3, '2023-05-03 15:25:21', '2023-05-03 15:26:03', NULL, ''),
	(28, 1, 'Settings', '', '_self', 'voyager-settings', '#000000', NULL, 7, '2023-05-03 15:25:50', '2023-11-02 12:50:08', NULL, ''),
	(29, 3, 'Om os', '/about', '_self', NULL, '#000000', NULL, 3, '2023-05-03 15:26:38', '2023-11-01 15:05:43', NULL, ''),
	(31, 1, 'Support Tickets', '', '_self', 'voyager-ticket', '#000000', 28, 5, '2023-05-11 00:40:42', '2023-10-05 05:58:00', 'voyager.tickets.index', 'null'),
	(32, 4, 'About', 'hello', '_self', NULL, '#000000', NULL, 14, '2023-05-17 00:35:54', '2023-05-17 00:35:54', NULL, ''),
	(33, 1, 'Ordes', '', '_self', 'voyager-receipt', '#000000', NULL, 6, '2023-08-09 01:40:20', '2023-11-02 12:50:08', NULL, ''),
	(34, 5, 'home', '/', '_self', NULL, '#000000', NULL, 15, '2023-09-03 01:44:11', '2023-09-03 01:44:11', NULL, ''),
	(35, 1, 'Cities', '', '_self', 'voyager-list-add', NULL, 24, 2, '2023-09-19 04:28:14', '2023-10-05 06:00:49', 'voyager.cities.index', NULL),
	(37, 1, 'Facilities', '', '_self', 'voyager-news', '#000000', 24, 1, '2023-09-25 16:44:21', '2023-09-25 16:46:32', 'voyager.facilities.index', 'null'),
	(38, 1, 'Contacts', '', '_self', 'voyager-logbook', NULL, NULL, 8, '2023-09-26 10:56:10', '2023-11-02 12:50:08', 'voyager.contacts.index', NULL),
	(39, 3, 'Forside', '/', '_self', NULL, '#000000', NULL, 1, '2023-10-07 21:17:08', '2023-11-01 15:04:29', NULL, ''),
	(42, 3, 'Deals', '/shops', '_self', NULL, '#000000', NULL, 2, '2023-10-07 21:19:35', '2023-11-01 15:04:48', NULL, ''),
	(43, 3, 'Kontakt', '/contact', '_self', NULL, '#000000', NULL, 8, '2023-10-07 21:20:00', '2024-03-23 15:15:25', NULL, ''),
	(45, 3, 'Handelsbetingelser', 'page/handelsbetingelser', '_self', NULL, '#000000', NULL, 7, '2023-11-01 14:29:18', '2024-03-23 15:15:30', NULL, ''),
	(47, 3, 'Sådan fungerer Halaldeals.dk', 'page/Sådan fungerer Halaldeals.dk', '_self', NULL, '#000000', NULL, 5, '2023-11-01 15:05:27', '2024-03-23 15:15:35', NULL, ''),
	(48, 1, 'News', '', '_self', 'voyager-news', '#000000', NULL, 4, '2023-11-02 12:49:54', '2023-11-02 12:50:08', NULL, ''),
	(49, 1, 'Post', '/admin/posts', '_self', 'voyager-news', '#000000', 48, 1, '2023-11-02 12:50:33', '2023-11-02 12:52:29', NULL, ''),
	(50, 1, 'Category', '/admin/categories', '_self', 'voyager-tag', '#000000', 48, 2, '2023-11-02 12:51:58', '2023-11-02 12:53:02', NULL, ''),
	(51, 1, 'Languages', '', '_self', 'voyager-book', NULL, NULL, 16, '2023-11-03 21:26:39', '2023-11-03 21:26:39', 'voyager.languages.index', NULL),
	(53, 1, 'Emails', '', '_self', 'voyager-mail', NULL, NULL, 17, '2024-03-31 14:26:21', '2024-03-31 14:26:21', 'voyager.emails.index', NULL);

-- Dumping structure for table ticket.metas
CREATE TABLE IF NOT EXISTS `metas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `metable_id` bigint NOT NULL,
  `metable_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `column_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `column_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.metas: ~27 rows (approximately)
INSERT INTO `metas` (`id`, `metable_id`, `metable_type`, `column_name`, `column_value`, `created_at`, `updated_at`) VALUES
	(13, 9, 'App\\Models\\User', 'phone', '+1 (924) 591-6431', '2023-09-10 05:48:54', '2023-09-10 05:59:04'),
	(14, 9, 'App\\Models\\User', 'country', 'Denmark', '2023-09-10 05:48:54', '2023-10-20 15:21:01'),
	(15, 9, 'App\\Models\\User', 'state', 'Region Zealand', '2023-09-10 05:48:54', '2023-10-20 15:21:01'),
	(16, 9, 'App\\Models\\User', 'city', 'Quia omnis rerum qui', '2023-09-10 05:48:54', '2023-09-10 05:59:04'),
	(17, 9, 'App\\Models\\User', 'post_code', '424', '2023-09-10 05:48:54', '2023-09-10 05:59:04'),
	(18, 9, 'App\\Models\\User', 'address', 'Ut unde dolorem quo', '2023-09-10 05:48:54', '2023-09-10 05:59:04'),
	(19, 10, 'App\\Models\\User', 'phone', '01319828234', '2023-09-12 04:41:37', '2023-09-12 04:41:37'),
	(20, 11, 'App\\Models\\User', 'phone', '01409590736', '2023-09-12 04:48:30', '2023-09-12 04:48:30'),
	(21, 11, 'App\\Models\\User', 'country', 'United States', '2023-09-12 04:48:30', '2023-09-12 04:48:30'),
	(22, 11, 'App\\Models\\User', 'state', 'New York', '2023-09-12 04:48:30', '2023-09-12 04:48:30'),
	(23, 11, 'App\\Models\\User', 'city', 'barishal', '2023-09-12 04:48:30', '2023-09-12 04:48:30'),
	(24, 11, 'App\\Models\\User', 'post_code', '45541', '2023-09-12 04:48:30', '2023-09-12 04:48:30'),
	(25, 11, 'App\\Models\\User', 'address', 'sdmsdkfjskfjsok', '2023-09-12 04:48:30', '2023-09-12 04:48:30'),
	(26, 8, 'App\\Models\\User', 'phone', '01305065919', '2023-09-16 14:18:34', '2023-09-16 14:18:34'),
	(27, 2, 'App\\Models\\User', 'phone', '01305065919', '2023-09-21 16:56:58', '2023-09-21 16:56:58'),
	(28, 37, 'App\\Models\\User', 'phone', '01926184022', '2023-10-05 05:48:53', '2023-10-05 05:48:53'),
	(29, 37, 'App\\Models\\User', 'country', 'Denmark', '2023-10-05 05:48:53', '2023-10-05 05:48:53'),
	(30, 37, 'App\\Models\\User', 'state', 'Capital Region of Denmark', '2023-10-05 05:48:53', '2023-10-05 05:48:53'),
	(31, 37, 'App\\Models\\User', 'city', 'test', '2023-10-05 05:48:53', '2023-10-05 05:48:53'),
	(32, 37, 'App\\Models\\User', 'post_code', '1240', '2023-10-05 05:48:53', '2023-10-05 05:48:53'),
	(33, 37, 'App\\Models\\User', 'address', 'savar\r\nasdasd', '2023-10-05 05:48:53', '2023-10-05 05:48:53'),
	(34, 11, 'App\\Models\\Shop', 'menuTitle1', 'Dette er menu 1', '2023-10-20 15:21:23', '2023-10-20 15:21:23'),
	(35, 11, 'App\\Models\\Shop', 'menuLink1', NULL, '2023-10-20 15:21:23', '2023-10-20 15:21:23'),
	(36, 11, 'App\\Models\\Shop', 'menuTitle2', 'Dette er menu 2', '2023-10-20 15:21:23', '2023-10-20 15:21:23'),
	(37, 11, 'App\\Models\\Shop', 'menuLink2', NULL, '2023-10-20 15:21:23', '2023-10-20 15:21:23'),
	(38, 38, 'App\\Models\\User', 'phone', '28599786', '2024-04-30 15:28:05', '2024-05-02 12:46:19'),
	(39, 79, 'App\\Models\\User', 'phone', '01303550622', '2024-07-25 23:22:45', '2024-07-25 23:22:45');

-- Dumping structure for table ticket.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.migrations: ~57 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2016_01_01_000000_add_voyager_user_fields', 1),
	(4, '2016_01_01_000000_create_data_types_table', 1),
	(5, '2016_01_01_000000_create_pages_table', 1),
	(6, '2016_01_01_000000_create_posts_table', 1),
	(7, '2016_02_15_204651_create_categories_table', 1),
	(8, '2016_05_19_173453_create_menu_table', 1),
	(9, '2016_10_21_190000_create_roles_table', 1),
	(10, '2016_10_21_190000_create_settings_table', 1),
	(11, '2016_11_30_135954_create_permission_table', 1),
	(12, '2016_11_30_141208_create_permission_role_table', 1),
	(13, '2016_12_26_201236_data_types__add__server_side', 1),
	(14, '2017_01_13_000000_add_route_to_menu_items_table', 1),
	(15, '2017_01_14_005015_create_translations_table', 1),
	(16, '2017_01_15_000000_make_table_name_nullable_in_permissions_table', 1),
	(17, '2017_03_06_000000_add_controller_to_data_types_table', 1),
	(18, '2017_04_11_000000_alter_post_nullable_fields_table', 1),
	(19, '2017_04_21_000000_add_order_to_data_rows_table', 1),
	(20, '2017_07_05_210000_add_policyname_to_data_types_table', 1),
	(21, '2017_08_05_000000_add_group_to_settings_table', 1),
	(22, '2017_11_26_013050_add_user_role_relationship', 1),
	(23, '2017_11_26_015000_create_user_roles_table', 1),
	(24, '2018_03_11_000000_add_user_settings', 1),
	(25, '2018_03_14_000000_add_details_to_data_types_table', 1),
	(26, '2018_03_16_000000_make_settings_value_nullable', 1),
	(27, '2019_05_03_000001_create_customer_columns', 1),
	(28, '2019_05_03_000002_create_subscriptions_table', 1),
	(29, '2019_05_03_000003_create_subscription_items_table', 1),
	(30, '2019_08_19_000000_create_failed_jobs_table', 1),
	(31, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(32, '2023_02_22_055833_create_products_table', 1),
	(33, '2023_02_22_072723_create_shops_table', 1),
	(34, '2023_02_22_073354_create_orders_table', 1),
	(35, '2023_02_22_080337_create_addresses_table', 1),
	(36, '2023_02_22_112352_add_new_shop_id__to_table', 1),
	(37, '2023_02_25_071011_create_coupons_table', 1),
	(38, '2023_02_25_074950_create_prodcats_table', 1),
	(39, '2023_02_25_075231_create_prodcat_products_table', 1),
	(40, '2023_03_05_055741_create_order_product_table', 1),
	(41, '2023_03_17_053256_create_metas_table', 1),
	(42, '2023_03_18_073329_create_ratings_table', 1),
	(43, '2023_04_02_195652_create_emails_table', 1),
	(44, '2023_04_13_072524_create_massages_table', 1),
	(45, '2023_04_13_085601_create_shop_user_table', 1),
	(46, '2023_04_13_091356_add_views_column_to_products', 1),
	(47, '2023_05_02_064255_create_shop_policies_table', 1),
	(48, '2023_05_03_170047_create_verifications_table', 1),
	(49, '2023_05_07_084108_create_offers_table', 1),
	(50, '2023_05_10_055120_create_tickets_table', 1),
	(51, '2023_05_16_110306_add_paid_at_to_users_table', 1),
	(52, '2023_05_21_202607_create_notifications_table', 1),
	(53, '2023_05_28_085316_create_jobs_table', 1),
	(54, '2023_07_08_071244_create_feedback_table', 1),
	(55, '2023_09_09_062132_create_attributes_table', 2),
	(56, '2023_09_09_062650_create_sliders_table', 2),
	(57, '2024_07_25_191328_add_event_start_to_products_table', 3);

-- Dumping structure for table ticket.notifications
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `shop_id` bigint unsigned NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=Unseen 1=seen',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_user_id_foreign` (`user_id`),
  KEY `notifications_shop_id_foreign` (`shop_id`),
  CONSTRAINT `notifications_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE,
  CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.notifications: ~0 rows (approximately)

-- Dumping structure for table ticket.offers
CREATE TABLE IF NOT EXISTS `offers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `product_id` bigint unsigned DEFAULT NULL,
  `shop_id` bigint unsigned DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `images` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `expired_at` timestamp NULL DEFAULT NULL,
  `featured` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `offers_user_id_foreign` (`user_id`),
  KEY `offers_product_id_foreign` (`product_id`),
  KEY `offers_shop_id_foreign` (`shop_id`),
  CONSTRAINT `offers_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `offers_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE,
  CONSTRAINT `offers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.offers: ~3 rows (approximately)
INSERT INTO `offers` (`id`, `user_id`, `product_id`, `shop_id`, `title`, `slug`, `description`, `created_at`, `updated_at`, `images`, `expired_at`, `featured`) VALUES
	(1, NULL, NULL, 11, 'Et reprehenderit it', 'et-reprehenderit-it', '<p>Necessitatibus elige</p>', '2023-09-23 23:45:00', '2023-09-24 13:46:21', '["offers\\/September2023\\/6lsMyOeLeKSMUypD3bPo.jpg","offers\\/September2023\\/id9GXmnArIrAPrCQy1iu.jpg"]', '2023-09-29 05:44:00', 0),
	(2, NULL, NULL, 11, 'Sunt amet suscipit', 'sunt-amet-suscipit', '<p>Sit dolor quisquam</p>', '2023-09-24 00:10:00', '2023-09-24 13:45:43', '["offers\\/September2023\\/FDs9rkiuKQbF63XYAq0m.jpg","offers\\/September2023\\/W8JG1b9QTZA2Z5KNw03d.jpg"]', '2023-09-24 06:10:00', 1),
	(3, NULL, NULL, 11, 'Quo quisquam exercit', 'quo-quisquam-exercit', '<p>Quo quisquam exercitQuo quisquam exercitQuo quisquam exercitQuo quisquam exercitQuo quisquam exercit</p>', '2023-09-24 13:47:05', '2023-09-24 13:47:05', '["offers\\/September2023\\/JrYYdWr8bIvcfyiIpTxn.jpg","offers\\/September2023\\/fDxSGr7D3vNZKC1BpJ4s.jpg"]', '2023-09-25 19:46:00', 0);

-- Dumping structure for table ticket.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=pending 1=fulfill 2=cancle ',
  `currency` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount` int DEFAULT NULL,
  `discount_code` int DEFAULT NULL,
  `shipping_total` int DEFAULT NULL,
  `shipping_method` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtotal` int NOT NULL,
  `total` int NOT NULL,
  `seen` tinyint(1) DEFAULT NULL,
  `tax` int DEFAULT NULL,
  `customer_note` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `shipping` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `payment_method` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method_title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_paid` timestamp NULL DEFAULT NULL,
  `date_completed` timestamp NULL DEFAULT NULL,
  `refund_amount` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aptment` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign` (`user_id`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ticket.orders: ~4 rows (approximately)
INSERT INTO `orders` (`id`, `user_id`, `status`, `currency`, `discount`, `discount_code`, `shipping_total`, `shipping_method`, `shipping_url`, `subtotal`, `total`, `seen`, `tax`, `customer_note`, `billing`, `shipping`, `payment_method`, `payment_method_title`, `transaction_id`, `date_paid`, `date_completed`, `refund_amount`, `company`, `aptment`, `quantity`, `created_at`, `updated_at`) VALUES
	(4, 81, 4, NULL, 0, NULL, NULL, NULL, NULL, 200, 200, NULL, 0, NULL, NULL, '{"first_name":"Chancellor Fry","last_name":"Jillian Sweeney","email":"xewaxomy@mailinator.com","phone":"01118286120"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-26 15:02:24', '2024-07-26 15:02:24'),
	(5, 81, 4, NULL, 0, NULL, NULL, NULL, NULL, 500, 500, NULL, 0, NULL, NULL, '{"first_name":"Chancellor Fry","last_name":"Jillian Sweeney","email":"xewaxomy@mailinator.com","phone":"01262383884"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-26 15:54:08', '2024-07-26 15:54:08'),
	(6, 82, 4, NULL, 0, NULL, NULL, NULL, NULL, 800, 800, NULL, 0, NULL, NULL, '{"first_name":"Ayanna Mathews","last_name":"Mechelle Phillips","email":"sycisy@mailinator.com","phone":"01711115464"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-26 22:16:53', '2024-07-26 22:16:53'),
	(7, 82, 4, NULL, 0, NULL, NULL, NULL, NULL, 500, 500, NULL, 0, NULL, NULL, '{"first_name":"Ayanna Mathews","last_name":"Mechelle Phillips","email":"sycisy@mailinator.com","phone":"01110907690"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-27 00:11:11', '2024-07-27 00:11:11');

-- Dumping structure for table ticket.order_product
CREATE TABLE IF NOT EXISTS `order_product` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `order_id` bigint unsigned NOT NULL,
  `ticket` text COLLATE utf8mb4_general_ci,
  `price` int NOT NULL,
  `check_in_at` timestamp NULL DEFAULT NULL,
  `check_out_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_product_product_id_foreign` (`product_id`),
  KEY `order_product_order_id_foreign` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ticket.order_product: ~20 rows (approximately)
INSERT INTO `order_product` (`id`, `product_id`, `order_id`, `ticket`, `price`, `check_in_at`, `check_out_at`, `created_at`, `updated_at`) VALUES
	(1, 97, 4, 'm9PtkbkxCf', 100, NULL, NULL, '2024-07-26 15:02:24', '2024-07-26 15:02:24'),
	(2, 98, 4, 'mzbe6jaJBC', 100, NULL, NULL, '2024-07-26 15:02:24', '2024-07-26 15:02:24'),
	(3, 98, 5, '98-uFY9p0VIyX-260724', 100, NULL, NULL, '2024-07-26 15:54:08', '2024-07-26 15:54:08'),
	(4, 98, 5, '98-U3f6cFMHlB-260724', 100, NULL, NULL, '2024-07-26 15:54:08', '2024-07-26 15:54:08'),
	(5, 98, 5, '98-P70aN3UL93-260724', 100, NULL, NULL, '2024-07-26 15:54:08', '2024-07-26 15:54:08'),
	(6, 98, 5, '98-lJBydPRAfP-260724', 100, NULL, NULL, '2024-07-26 15:54:08', '2024-07-26 15:54:08'),
	(7, 98, 5, '98-31zRv4Zjg4-260724', 100, NULL, NULL, '2024-07-26 15:54:08', '2024-07-26 15:54:08'),
	(8, 97, 6, '97-6rCKjJ9BPo-270724', 100, NULL, NULL, '2024-07-26 22:16:53', '2024-07-26 22:16:53'),
	(9, 97, 6, '97-PKU9IukLaA-270724', 100, NULL, NULL, '2024-07-26 22:16:53', '2024-07-26 22:16:53'),
	(10, 97, 6, '97-qdxIcr8uuO-270724', 100, NULL, NULL, '2024-07-26 22:16:53', '2024-07-26 22:16:53'),
	(11, 97, 6, '97-T2rIigc6CA-270724', 100, NULL, NULL, '2024-07-26 22:16:53', '2024-07-26 22:16:53'),
	(12, 97, 6, '97-NoabrGVkHm-270724', 100, NULL, NULL, '2024-07-26 22:16:53', '2024-07-26 22:16:53'),
	(13, 97, 6, '97-WBP2laiztM-270724', 100, NULL, NULL, '2024-07-26 22:16:53', '2024-07-26 22:16:53'),
	(14, 97, 6, '97-b0IUbPlp4x-270724', 100, NULL, NULL, '2024-07-26 22:16:53', '2024-07-26 22:16:53'),
	(15, 97, 6, '97-NLLnXANLQ5-270724', 100, NULL, NULL, '2024-07-26 22:16:53', '2024-07-26 22:16:53'),
	(16, 98, 7, '98-OzpGy834Tc-270724', 100, NULL, NULL, '2024-07-27 00:11:11', '2024-07-27 00:11:11'),
	(17, 98, 7, '98-iY2JG28nsR-270724', 100, NULL, NULL, '2024-07-27 00:11:11', '2024-07-27 00:11:11'),
	(18, 98, 7, '98-1VwH1lPob8-270724', 100, NULL, NULL, '2024-07-27 00:11:11', '2024-07-27 00:11:11'),
	(19, 101, 7, '101-lERAWyqMoi-270724', 100, NULL, NULL, '2024-07-27 00:11:11', '2024-07-27 00:11:11'),
	(20, 101, 7, '101-4ViQsx8pdD-270724', 100, NULL, NULL, '2024-07-27 00:11:11', '2024-07-27 00:11:11');

-- Dumping structure for table ticket.pages
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `author_id` int NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `meta_keywords` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('ACTIVE','INACTIVE') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'INACTIVE',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pages_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.pages: ~3 rows (approximately)
INSERT INTO `pages` (`id`, `author_id`, `title`, `excerpt`, `body`, `image`, `slug`, `meta_description`, `meta_keywords`, `status`, `created_at`, `updated_at`) VALUES
	(1, 2, 'Sådan fungerer Halaldeals.dk', 'Hang the jib grog grog blossom grapple dance the hempen jig gangway pressgang bilge rat to go on account lugger. Nelsons folly gabion line draught scallywag fire ship gaff fluke fathom case shot. Sea Legs bilge rat sloop matey gabion long clothes run a shot across the bow Gold Road cog league.', '<p><strong>S&aring;dan Handler Du p&aring; Halaldeals.dk</strong></p>\r\n<p>Hos Halaldeals.dk str&aelig;ber vi efter at give dig mulighed for at opleve unikke og mindev&aelig;rdige oplevelser. Vores fokus ligger p&aring; at pr&aelig;sentere dig for oplevelser, som m&aring;ske ikke altid er de billigste, men som vil berige dit liv og &aring;bne d&oslash;re til nye eventyr. Her er en enkel vejledning til, hvordan du handler p&aring; Halaldeals.dk:</p>\r\n<p><strong>1. Find Din Dr&oslash;mme-Deal:</strong></p>\r\n<ul>\r\n<li>Gennemse vores udvalg af deals og find den, der v&aelig;kker din interesse. Det kan v&aelig;re et restaurantbes&oslash;g, en rejseoplevelse, eller noget helt tredje, der fanger din opm&aelig;rksomhed.</li>\r\n</ul>\r\n<p><strong>2. K&oslash;b Din Deal:</strong></p>\r\n<ul>\r\n<li>N&aring;r du har fundet din &oslash;nskede deal, skal du blot klikke p&aring; "K&oslash;b nu" knappen. Dette f&oslash;rer dig til k&oslash;bssiden, hvor du indtaster de n&oslash;dvendige oplysninger. Vi har gjort det hurtigt, nemt og enkelt for dig.</li>\r\n</ul>\r\n<p><strong>3. Giv En Oplevelse som Gave:</strong></p>\r\n<ul>\r\n<li>Hvis du &oslash;nsker at give dealen som gave, kan du markere den som en gave under k&oslash;bsprocessen. Du vil derefter modtage et flot gavebevis, som du kan give til den heldige modtager. Vi tilbyder ogs&aring; gavekort, s&aring; modtageren selv kan v&aelig;lge sin &oslash;nskede deal.</li>\r\n</ul>\r\n<p><strong>4. Modtag Dit V&aelig;rdibevis:</strong></p>\r\n<ul>\r\n<li>Umiddelbart efter dit k&oslash;b vil du modtage en e-mail med dit v&aelig;rdibevis. Hvis du mod forventning ikke modtager v&aelig;rdibeviset i din indbakke, bedes du tjekke din reklame- eller spam-mappe, da vores e-mails nogle gange havner her.</li>\r\n</ul>\r\n<p><strong>5. Bestil Din Oplevelse:</strong></p>\r\n<ul>\r\n<li>N&aring;r du har modtaget dit v&aelig;rdibevis, kan du begynde at booke din oplevelse, middag, rejse, ophold eller behandling. Hvis du har k&oslash;bt en vare, skal du se frem til at modtage den, og v&aelig;r opm&aelig;rksom p&aring;, at nogle produkter sendes, n&aring;r dealen udl&oslash;ber p&aring; vores hjemmeside. Dit v&aelig;rdibevis indeholder information om, hvorn&aring;r du kan forvente at modtage dit produkt.</li>\r\n</ul>\r\n<p><strong>6. Nyd Din Oplevelse:</strong></p>\r\n<ul>\r\n<li>Til sidst er det blot at nyde dit k&oslash;b! Brug dit v&aelig;rdibevis til at f&aring; mest muligt ud af den deal, du har valgt. Vi &oslash;nsker dig en fantastisk oplevelse og rigtig god forn&oslash;jelse!</li>\r\n</ul>\r\n<p>Vi ser frem til at hj&aelig;lpe dig med at skabe uforglemmelige minder og &aring;bne d&oslash;re til sp&aelig;ndende oplevelser p&aring; Halaldeals.dk. Tak for at v&aelig;re en del af vores f&aelig;llesskab, og vi er her for at sikre, at du f&aring;r det bedste ud af dine deals.</p>', 'pages/page1.jpg', 'Sådan fungerer Halaldeals.dk', 'Sådan fungerer Halaldeals.dk', 'Sådan fungerer Halaldeals.dk', 'ACTIVE', '2023-09-08 23:30:27', '2023-10-20 14:47:57'),
	(2, 2, 'Handelsbetingelser', 'Handelsbetingelser for Halaldeals.dk\r\n\r\nVelkommen til Halaldeals.dk. Disse handelsbetingelser udgør den juridiske aftale mellem dig og Halaldeals.dk (herefter "vi", "os" eller "vores"), når du foretager et køb på vores platform. Læs venligst følgende betingelser omhyggeligt, da de regulerer dine rettigheder og forpligtelser i forhold til dine køb.', '<div class="group final-completion w-full text-token-text-primary border-b border-black/10 gizmo:border-0 dark:border-gray-900/50 gizmo:dark:border-0 bg-gray-50 gizmo:bg-transparent dark:bg-[#444654] gizmo:dark:bg-transparent sm:AIPRM__conversation__response" data-testid="conversation-turn-13">\r\n<div class="p-4 justify-center text-base md:gap-6 md:py-6 m-auto">\r\n<div class="flex flex-1 gap-4 text-base mx-auto md:gap-6 gizmo:gap-3 gizmo:md:px-5 gizmo:lg:px-1 gizmo:xl:px-5 md:max-w-2xl lg:max-w-[38rem] gizmo:md:max-w-3xl gizmo:lg:max-w-[40rem] gizmo:xl:max-w-[48rem] xl:max-w-3xl }">\r\n<div class="relative flex w-[calc(100%-50px)] flex-col gizmo:w-full lg:w-[calc(100%-115px)] agent-turn">\r\n<div class="flex-col gap-1 md:gap-3">\r\n<div class="flex flex-grow flex-col gap-3 max-w-full">\r\n<div class="min-h-[20px] flex flex-col items-start gap-3 whitespace-pre-wrap break-words overflow-x-auto">\r\n<div class="markdown prose w-full break-words dark:prose-invert dark AIPRM__conversation__response">\r\n<p><strong>Handelsbetingelser for Halaldeals.dk</strong></p>\r\n<p>Velkommen til Halaldeals.dk. Disse handelsbetingelser udg&oslash;r den juridiske aftale mellem dig og Halaldeals.dk (herefter "vi", "os" eller "vores"), n&aring;r du foretager et k&oslash;b p&aring; vores platform. L&aelig;s venligst f&oslash;lgende betingelser omhyggeligt, da de regulerer dine rettigheder og forpligtelser i forhold til dine k&oslash;b.</p>\r\n<p><strong>Generelle Handelsbetingelser:</strong></p>\r\n<ol>\r\n<li>\r\n<p><strong>K&oslash;b af Deals:</strong> N&aring;r du k&oslash;ber en deal p&aring; Halaldeals.dk, vil du modtage en bekr&aelig;ftelse via e-mail, der inkluderer oplysninger som dit navn, e-mailadresse og telefonnummer samt en unik indl&oslash;sningskode og i nogle tilf&aelig;lde en QR-kode.</p>\r\n</li>\r\n<li>\r\n<p><strong>Betaling:</strong> Vi accepterer betaling via kreditkort og betalingsgateway Viva wallet. Betaling vil blive behandlet sikkert og fortroligt.</p>\r\n</li>\r\n<li>\r\n<p><strong>Returret og Refunderinger:</strong> Du har ret til at returnere eller anmode om en refundering af dit k&oslash;b inden for 30 dage efter k&oslash;bsdatoen. Bem&aelig;rk, at returret og refundering ikke er g&aelig;ldende, n&aring;r kampagnen er afsluttet. For at anmode om en retur eller refundering bedes du kontakte os p&aring; <a href="mailto:info@halaldeals.dk" target="_new">info@halaldeals.dk</a>.</p>\r\n</li>\r\n<li>\r\n<p><strong>Kontakt:</strong> Hvis du har sp&oslash;rgsm&aring;l, bekymringer eller behov for at kontakte os, er du velkommen til at sende en e-mail til <a href="mailto:info@halaldeals.dk" target="_new">info@halaldeals.dk</a>. Vi vil bestr&aelig;be os p&aring; at besvare din henvendelse s&aring; hurtigt som muligt.</p>\r\n</li>\r\n<li>\r\n<p><strong>Personlige Oplysninger:</strong> Vi beskytter dine personlige oplysninger og f&oslash;lger alle g&aelig;ldende love og regler vedr&oslash;rende databeskyttelse. V&aelig;r opm&aelig;rksom p&aring; vores privatlivspolitik for yderligere oplysninger.</p>\r\n</li>\r\n<li>\r\n<p><strong>&AElig;ndringer og Annulleringer:</strong> Vi forbeholder os retten til at &aelig;ndre eller annullere en deal eller kampagne efter eget sk&oslash;n, herunder at &aelig;ndre betingelser og priser.</p>\r\n</li>\r\n<li>\r\n<p><strong>Intellektuel Ejendom:</strong> Alt indhold p&aring; Halaldeals.dk, herunder billeder, tekster og logoer, er beskyttet af ophavsret og m&aring; ikke kopieres eller bruges uden tilladelse.</p>\r\n</li>\r\n<li>\r\n<p><strong>Ansvarsfraskrivelse:</strong> Vi bestr&aelig;ber os p&aring; at levere n&oslash;jagtige oplysninger om deals og partnere, men kan ikke holdes ansvarlige for eventuelle &aelig;ndringer eller afvigelser i forhold til det annoncerede.</p>\r\n</li>\r\n<li>\r\n<p><strong>Lokale Love og Regler:</strong> V&aelig;r opm&aelig;rksom p&aring; lokale love og regler vedr&oslash;rende rettigheder og forbrugerbeskyttelse, der kan g&aelig;lde for dine k&oslash;b.</p>\r\n</li>\r\n</ol>\r\n<p>Ved at forts&aelig;tte med dit k&oslash;b p&aring; Halaldeals.dk accepterer du disse handelsbetingelser og forpligter dig til at f&oslash;lge dem. Vi s&aelig;tter pris p&aring; din tillid og ser frem til at give dig fantastiske deals og service.</p>\r\n</div>\r\n</div>\r\n</div>\r\n<div class="flex justify-between empty:hidden gizmo:justify-start gizmo:gap-3 lg:block">\r\n<div class="text-gray-400 flex self-end lg:self-center justify-center gizmo:lg:justify-start mt-2 gizmo:mt-0 visible lg:gap-1 lg:absolute lg:top-0 lg:translate-x-full lg:right-0 lg:mt-0 lg:pl-2 gap-2 md:gap-3"><button class="flex ml-auto gizmo:ml-0 gap-2 items-center rounded-md p-1 text-xs gizmo:gap-1.5 gizmo:pl-0 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200 disabled:dark:hover:text-gray-400 hover:bg-gray-100 hover:text-gray-700"></button>\r\n<div class="flex gap-1 gizmo:gap-3">\r\n<div class="group final-completion w-full text-token-text-primary border-b border-black/10 gizmo:border-0 dark:border-gray-900/50 gizmo:dark:border-0 bg-gray-50 gizmo:bg-transparent dark:bg-[#444654] gizmo:dark:bg-transparent sm:AIPRM__conversation__response" data-testid="conversation-turn-15">\r\n<div class="p-4 justify-center text-base md:gap-6 md:py-6 m-auto">\r\n<div class="flex flex-1 gap-4 text-base mx-auto md:gap-6 gizmo:gap-3 gizmo:md:px-5 gizmo:lg:px-1 gizmo:xl:px-5 md:max-w-2xl lg:max-w-[38rem] gizmo:md:max-w-3xl gizmo:lg:max-w-[40rem] gizmo:xl:max-w-[48rem] xl:max-w-3xl }">\r\n<div class="relative flex w-[calc(100%-50px)] flex-col gizmo:w-full lg:w-[calc(100%-115px)] agent-turn">\r\n<div class="flex-col gap-1 md:gap-3">\r\n<div class="flex flex-grow flex-col gap-3 max-w-full">\r\n<div class="min-h-[20px] flex flex-col items-start gap-3 whitespace-pre-wrap break-words overflow-x-auto">\r\n<div class="markdown prose w-full break-words dark:prose-invert dark AIPRM__conversation__response">\r\n<p>GDPR (General Data Protection Regulation) er en europ&aelig;isk forordning, der tr&aring;dte i kraft den 25. maj 2018. Den har til form&aring;l at beskytte enkeltpersoners privatliv og personlige data ved at regulere indsamling, opbevaring og behandling af data. Her er nogle vigtige oplysninger om GDPR:</p>\r\n<p><strong>Hvad er GDPR?</strong></p>\r\n<p>GDPR er en lovgivning, der regulerer, hvordan virksomheder og organisationer behandler personoplysninger om enkeltpersoner, herunder kunder, medarbejdere og andre interessenter. Denne forordning er designet til at give enkeltpersoner mere kontrol over deres personlige data og beskytte deres rettigheder.</p>\r\n<p><strong>Hvem er omfattet af GDPR?</strong></p>\r\n<p>GDPR g&aelig;lder for alle organisationer, der behandler personoplysninger om personer inden for EU og E&Oslash;S-omr&aring;det, uanset hvor organisationen selv er baseret. Dette betyder, at virksomheder over hele verden kan v&aelig;re forpligtet til at overholde GDPR-regler, hvis de behandler data fra europ&aelig;iske borgere.</p>\r\n<p><strong>Principperne i GDPR:</strong></p>\r\n<ul>\r\n<li>\r\n<p><strong>Samtykke:</strong> Organisationer skal indhente klart og frivilligt samtykke fra enkeltpersoner, f&oslash;r de indsamler og behandler deres personlige data.</p>\r\n</li>\r\n<li>\r\n<p><strong>Form&aring;lsbegr&aelig;nsning:</strong> Data m&aring; kun indsamles til specifikke og lovlige form&aring;l, og de m&aring; ikke behandles p&aring; en m&aring;de, der er uforenelig med disse form&aring;l.</p>\r\n</li>\r\n<li>\r\n<p><strong>Dataminimering:</strong> Organisationer b&oslash;r kun indsamle og behandle de data, der er n&oslash;dvendige for det angivne form&aring;l.</p>\r\n</li>\r\n<li>\r\n<p><strong>N&oslash;jagtighed:</strong> Personlige data skal v&aelig;re n&oslash;jagtige og opdaterede. Organisationer skal tr&aelig;ffe foranstaltninger for at sikre dataenes n&oslash;jagtighed.</p>\r\n</li>\r\n<li>\r\n<p><strong>Lagerbegr&aelig;nsning:</strong> Data b&oslash;r ikke opbevares l&aelig;ngere end n&oslash;dvendigt for det form&aring;l, de blev indsamlet til.</p>\r\n</li>\r\n<li>\r\n<p><strong>Integritet og fortrolighed:</strong> Organisationer skal beskytte personlige data mod uautoriseret adgang og sikre deres fortrolighed og integritet.</p>\r\n</li>\r\n</ul>\r\n<p><strong>Rettigheder under GDPR:</strong></p>\r\n<p>Enkeltpersoner har en r&aelig;kke rettigheder i henhold til GDPR, herunder retten til at f&aring; adgang til deres data, retten til dataportabilitet og retten til at blive glemt. De har ogs&aring; ret til at blive underrettet om databrud og kan tr&aelig;kke deres samtykke tilbage n&aring;r som helst.</p>\r\n<p><strong>Konsekvenser af overtr&aelig;delse:</strong></p>\r\n<p>Organisationer, der ikke overholder GDPR-regler, kan blive p&aring;lagt b&oslash;der, der kan v&aelig;re betydelige, afh&aelig;ngigt af arten af overtr&aelig;delsen.</p>\r\n<p>GDPR er en vigtig regulering, der har til form&aring;l at beskytte individernes privatliv og sikre, at deres personlige data behandles p&aring; en retf&aelig;rdig og ansvarlig m&aring;de. Det er vigtigt for organisationer at forst&aring; og overholde GDPR-regler for at undg&aring; potentielle juridiske konsekvenser.</p>\r\n</div>\r\n</div>\r\n</div>\r\n<div class="flex justify-between empty:hidden gizmo:justify-start gizmo:gap-3 lg:block">\r\n<div class="text-gray-400 flex self-end lg:self-center justify-center gizmo:lg:justify-start mt-2 gizmo:mt-0 visible lg:gap-1 lg:absolute lg:top-0 lg:translate-x-full lg:right-0 lg:mt-0 lg:pl-2 gap-2 md:gap-3"><button class="flex ml-auto gizmo:ml-0 gap-2 items-center rounded-md p-1 text-xs gizmo:gap-1.5 gizmo:pl-0 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200 disabled:dark:hover:text-gray-400 hover:bg-gray-100 hover:text-gray-700"></button>\r\n<div class="flex gap-1 gizmo:gap-3">&nbsp;</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', NULL, 'handelsbetingelser', 'Handelsbetingelser for Halaldeals.dk  Velkommen til Halaldeals.dk. Disse handelsbetingelser udgør den juridiske aftale mellem dig og Halaldeals.dk (herefter "vi", "os" eller "vores"), når du foretager et køb på vores platform. Læs venligst følgende betingelser omhyggeligt, da de regulerer dine rettigheder og forpligtelser i forhold til dine køb.', 'Halaldeals.dk handelsbetingelser.', 'ACTIVE', '2023-10-20 14:28:18', '2023-10-20 14:28:18'),
	(3, 2, 'Hvorfor vælge Halaldeals.dk', 'Velkommen til Halaldeals.dk, hvor vores vision er at åbne døre til en verden af unikke oplevelser for muslimer og alle, der ønsker halal-venlige muligheder. Vores rejse startede med en enkel idé - at give vores samfund mulighed for at udforske og nyde oplevelser, som måske ikke altid har været tilgængelige på grund af manglende halal-tilbud.', '<p><strong>Om Os - &Aring;bning af D&oslash;re til Unikke Oplevelser</strong></p>\r\n<p>Velkommen til Halaldeals.dk, hvor vores vision er at &aring;bne d&oslash;re til en verden af unikke oplevelser for muslimer og alle, der &oslash;nsker halal-venlige muligheder. Vores rejse startede med en enkel id&eacute; - at give dig mulighed for at udforske og nyde oplevelser, som m&aring;ske ikke altid har v&aelig;ret tilg&aelig;ngelige p&aring; grund af manglende halal-tilbud.</p>\r\n<p><strong>Inspirerende Tanker bag Vores Eksistens</strong></p>\r\n<p>Vi tror p&aring;, at alle fortjener muligheden for at nyde livets skatte og skabe uforglemmelige minder. Tanken om at g&aring; ud og spise p&aring; en f&oslash;rsteklasses restaurant eller opleve luksuri&oslash;se hotelophold b&oslash;r ikke v&aelig;re begr&aelig;nset af religi&oslash;se hensyn. Derfor blev Halaldeals.dk skabt som et svar p&aring; denne udfordring.</p>\r\n<p><strong>S&aelig;rlige Oplevelser, Ikke Bare Tilbud</strong></p>\r\n<p>Hos Halaldeals.dk har vi ikke kun fokus p&aring; at give dig billige tilbud. Vores m&aring;l er at pr&aelig;sentere dig for unikke oplevelser, som m&aring;ske ikke altid er lige foran dig. Vi str&aelig;ber efter at finde de mest eksklusive hoteller, restauranter og sev&aelig;rdigheder, der tilbyder halal-muligheder, og pr&aelig;sentere dem p&aring; vores platform.</p>\r\n<p><strong>Samarbejde og Muligheder</strong></p>\r\n<p>Vi arbejder h&aring;rdt p&aring; at indg&aring; samarbejde med hoteller, restauranter og sev&aelig;rdigheder, der deler vores vision og v&aelig;rds&aelig;tter mangfoldighed og inklusion. Vi &oslash;nsker at skabe et rum, hvor vores kunder kan opleve noget s&aelig;rligt, uanset om det er en kulinarisk fest p&aring; en f&oslash;rsteklasses restaurant, et luksuri&oslash;st hotelophold eller en sp&aelig;ndende udflugt.</p>\r\n<p><strong>Din D&oslash;r til Unikke Oplevelser</strong></p>\r\n<p>Halaldeals.dk er her for at inspirere dig og give dig mulighed for at tr&aelig;de uden for din komfortzone og udforske verden af oplevelser, der er tilg&aelig;ngelige for alle. Vi er stolte af at v&aelig;re din vejledning til en verden af muligheder, hvor vi &aring;bner d&oslash;rene for unikke oplevelser for dig.</p>\r\n<p>S&aring; tak for at v&aelig;re en del af Halaldeals.dk-f&aelig;llesskabet. Vi ser frem til at dele sp&aelig;ndende eventyr og uforglemmelige &oslash;jeblikke med dig, og vi er dedikerede til at forts&aelig;tte med at bringe dig de mest eksklusive halal-oplevelser, du fortjener.</p>', NULL, 'hvorfor-vaelge-halaldeals-dk', 'Velkommen til Halaldeals.dk, hvor vores vision er at åbne døre til en verden af unikke oplevelser for muslimer og alle, der ønsker halal-venlige muligheder. Vores rejse startede med en enkel idé - at give vores samfund mulighed for at udforske og nyde oplevelser, som måske ikke altid har været tilgængelige på grund af manglende halal-tilbud.', 'Halaldeals.dk tilbud oplevelser', 'ACTIVE', '2023-10-20 14:40:40', '2023-10-20 14:40:40');

-- Dumping structure for table ticket.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.password_resets: ~1 rows (approximately)
INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
	('reovilsayed@gmail.com', '$2y$10$GFjnt1vOYYd/wAyDTV9GmuAHsJY1VYtlbFL93/Q3ITvkWywpcyKdC', '2023-09-26 08:22:36');

-- Dumping structure for table ticket.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permissions_key_index` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.permissions: ~120 rows (approximately)
INSERT INTO `permissions` (`id`, `key`, `table_name`, `created_at`, `updated_at`) VALUES
	(1, 'browse_admin', NULL, '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
	(2, 'browse_bread', NULL, '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
	(3, 'browse_database', NULL, '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
	(4, 'browse_media', NULL, '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
	(5, 'browse_compass', NULL, '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
	(6, 'browse_menus', 'menus', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
	(7, 'read_menus', 'menus', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
	(8, 'edit_menus', 'menus', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
	(9, 'add_menus', 'menus', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
	(10, 'delete_menus', 'menus', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
	(11, 'browse_roles', 'roles', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
	(12, 'read_roles', 'roles', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
	(13, 'edit_roles', 'roles', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
	(14, 'add_roles', 'roles', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
	(15, 'delete_roles', 'roles', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
	(16, 'browse_users', 'users', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
	(17, 'read_users', 'users', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
	(18, 'edit_users', 'users', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
	(19, 'add_users', 'users', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
	(20, 'delete_users', 'users', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
	(21, 'browse_settings', 'settings', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
	(22, 'read_settings', 'settings', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
	(23, 'edit_settings', 'settings', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
	(24, 'add_settings', 'settings', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
	(25, 'delete_settings', 'settings', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
	(26, 'browse_categories', 'categories', '2023-03-12 01:03:41', '2023-03-12 01:03:41'),
	(27, 'read_categories', 'categories', '2023-03-12 01:03:41', '2023-03-12 01:03:41'),
	(28, 'edit_categories', 'categories', '2023-03-12 01:03:41', '2023-03-12 01:03:41'),
	(29, 'add_categories', 'categories', '2023-03-12 01:03:41', '2023-03-12 01:03:41'),
	(30, 'delete_categories', 'categories', '2023-03-12 01:03:41', '2023-03-12 01:03:41'),
	(31, 'browse_posts', 'posts', '2023-03-12 01:03:41', '2023-03-12 01:03:41'),
	(32, 'read_posts', 'posts', '2023-03-12 01:03:41', '2023-03-12 01:03:41'),
	(33, 'edit_posts', 'posts', '2023-03-12 01:03:41', '2023-03-12 01:03:41'),
	(34, 'add_posts', 'posts', '2023-03-12 01:03:41', '2023-03-12 01:03:41'),
	(35, 'delete_posts', 'posts', '2023-03-12 01:03:41', '2023-03-12 01:03:41'),
	(36, 'browse_pages', 'pages', '2023-03-12 01:03:41', '2023-03-12 01:03:41'),
	(37, 'read_pages', 'pages', '2023-03-12 01:03:41', '2023-03-12 01:03:41'),
	(38, 'edit_pages', 'pages', '2023-03-12 01:03:41', '2023-03-12 01:03:41'),
	(39, 'add_pages', 'pages', '2023-03-12 01:03:41', '2023-03-12 01:03:41'),
	(40, 'delete_pages', 'pages', '2023-03-12 01:03:41', '2023-03-12 01:03:41'),
	(41, 'browse_products', 'products', '2023-04-07 11:28:10', '2023-04-07 11:28:10'),
	(42, 'read_products', 'products', '2023-04-07 11:28:10', '2023-04-07 11:28:10'),
	(43, 'edit_products', 'products', '2023-04-07 11:28:10', '2023-04-07 11:28:10'),
	(44, 'add_products', 'products', '2023-04-07 11:28:10', '2023-04-07 11:28:10'),
	(45, 'delete_products', 'products', '2023-04-07 11:28:10', '2023-04-07 11:28:10'),
	(46, 'browse_coupons', 'coupons', '2023-04-07 12:15:49', '2023-04-07 12:15:49'),
	(47, 'read_coupons', 'coupons', '2023-04-07 12:15:49', '2023-04-07 12:15:49'),
	(48, 'edit_coupons', 'coupons', '2023-04-07 12:15:49', '2023-04-07 12:15:49'),
	(49, 'add_coupons', 'coupons', '2023-04-07 12:15:49', '2023-04-07 12:15:49'),
	(50, 'delete_coupons', 'coupons', '2023-04-07 12:15:49', '2023-04-07 12:15:49'),
	(51, 'browse_addresses', 'addresses', '2023-04-07 12:26:46', '2023-04-07 12:26:46'),
	(52, 'read_addresses', 'addresses', '2023-04-07 12:26:46', '2023-04-07 12:26:46'),
	(53, 'edit_addresses', 'addresses', '2023-04-07 12:26:46', '2023-04-07 12:26:46'),
	(54, 'add_addresses', 'addresses', '2023-04-07 12:26:46', '2023-04-07 12:26:46'),
	(55, 'delete_addresses', 'addresses', '2023-04-07 12:26:46', '2023-04-07 12:26:46'),
	(56, 'browse_prodcats', 'prodcats', '2023-04-07 12:36:57', '2023-04-07 12:36:57'),
	(57, 'read_prodcats', 'prodcats', '2023-04-07 12:36:57', '2023-04-07 12:36:57'),
	(58, 'edit_prodcats', 'prodcats', '2023-04-07 12:36:57', '2023-04-07 12:36:57'),
	(59, 'add_prodcats', 'prodcats', '2023-04-07 12:36:57', '2023-04-07 12:36:57'),
	(60, 'delete_prodcats', 'prodcats', '2023-04-07 12:36:57', '2023-04-07 12:36:57'),
	(61, 'browse_ratings', 'ratings', '2023-04-07 12:44:57', '2023-04-07 12:44:57'),
	(62, 'read_ratings', 'ratings', '2023-04-07 12:44:57', '2023-04-07 12:44:57'),
	(63, 'edit_ratings', 'ratings', '2023-04-07 12:44:57', '2023-04-07 12:44:57'),
	(64, 'add_ratings', 'ratings', '2023-04-07 12:44:57', '2023-04-07 12:44:57'),
	(65, 'delete_ratings', 'ratings', '2023-04-07 12:44:57', '2023-04-07 12:44:57'),
	(66, 'browse_shops', 'shops', '2023-04-07 12:55:50', '2023-04-07 12:55:50'),
	(67, 'read_shops', 'shops', '2023-04-07 12:55:50', '2023-04-07 12:55:50'),
	(68, 'edit_shops', 'shops', '2023-04-07 12:55:50', '2023-04-07 12:55:50'),
	(69, 'add_shops', 'shops', '2023-04-07 12:55:50', '2023-04-07 12:55:50'),
	(70, 'delete_shops', 'shops', '2023-04-07 12:55:50', '2023-04-07 12:55:50'),
	(71, 'browse_orders', 'orders', '2023-04-08 09:32:52', '2023-04-08 09:32:52'),
	(72, 'read_orders', 'orders', '2023-04-08 09:32:52', '2023-04-08 09:32:52'),
	(73, 'edit_orders', 'orders', '2023-04-08 09:32:52', '2023-04-08 09:32:52'),
	(74, 'add_orders', 'orders', '2023-04-08 09:32:52', '2023-04-08 09:32:52'),
	(75, 'delete_orders', 'orders', '2023-04-08 09:32:52', '2023-04-08 09:32:52'),
	(76, 'browse_sliders', 'sliders', '2023-04-11 11:40:01', '2023-04-11 11:40:01'),
	(77, 'read_sliders', 'sliders', '2023-04-11 11:40:01', '2023-04-11 11:40:01'),
	(78, 'edit_sliders', 'sliders', '2023-04-11 11:40:01', '2023-04-11 11:40:01'),
	(79, 'add_sliders', 'sliders', '2023-04-11 11:40:01', '2023-04-11 11:40:01'),
	(80, 'delete_sliders', 'sliders', '2023-04-11 11:40:01', '2023-04-11 11:40:01'),
	(81, 'browse_verifications', 'verifications', '2023-05-04 11:43:33', '2023-05-04 11:43:33'),
	(82, 'read_verifications', 'verifications', '2023-05-04 11:43:33', '2023-05-04 11:43:33'),
	(83, 'edit_verifications', 'verifications', '2023-05-04 11:43:33', '2023-05-04 11:43:33'),
	(84, 'add_verifications', 'verifications', '2023-05-04 11:43:33', '2023-05-04 11:43:33'),
	(85, 'delete_verifications', 'verifications', '2023-05-04 11:43:33', '2023-05-04 11:43:33'),
	(86, 'browse_tickets', 'tickets', '2023-05-11 00:40:41', '2023-05-11 00:40:41'),
	(87, 'read_tickets', 'tickets', '2023-05-11 00:40:41', '2023-05-11 00:40:41'),
	(88, 'edit_tickets', 'tickets', '2023-05-11 00:40:41', '2023-05-11 00:40:41'),
	(89, 'add_tickets', 'tickets', '2023-05-11 00:40:41', '2023-05-11 00:40:41'),
	(90, 'delete_tickets', 'tickets', '2023-05-11 00:40:41', '2023-05-11 00:40:41'),
	(91, 'browse_cities', 'cities', '2023-09-19 04:28:14', '2023-09-19 04:28:14'),
	(92, 'read_cities', 'cities', '2023-09-19 04:28:14', '2023-09-19 04:28:14'),
	(93, 'edit_cities', 'cities', '2023-09-19 04:28:14', '2023-09-19 04:28:14'),
	(94, 'add_cities', 'cities', '2023-09-19 04:28:14', '2023-09-19 04:28:14'),
	(95, 'delete_cities', 'cities', '2023-09-19 04:28:14', '2023-09-19 04:28:14'),
	(96, 'browse_offers', 'offers', '2023-09-24 13:36:16', '2023-09-24 13:36:16'),
	(97, 'read_offers', 'offers', '2023-09-24 13:36:16', '2023-09-24 13:36:16'),
	(98, 'edit_offers', 'offers', '2023-09-24 13:36:16', '2023-09-24 13:36:16'),
	(99, 'add_offers', 'offers', '2023-09-24 13:36:16', '2023-09-24 13:36:16'),
	(100, 'delete_offers', 'offers', '2023-09-24 13:36:16', '2023-09-24 13:36:16'),
	(101, 'browse_facilities', 'facilities', '2023-09-25 16:44:21', '2023-09-25 16:44:21'),
	(102, 'read_facilities', 'facilities', '2023-09-25 16:44:21', '2023-09-25 16:44:21'),
	(103, 'edit_facilities', 'facilities', '2023-09-25 16:44:21', '2023-09-25 16:44:21'),
	(104, 'add_facilities', 'facilities', '2023-09-25 16:44:21', '2023-09-25 16:44:21'),
	(105, 'delete_facilities', 'facilities', '2023-09-25 16:44:21', '2023-09-25 16:44:21'),
	(106, 'browse_contacts', 'contacts', '2023-09-26 10:56:10', '2023-09-26 10:56:10'),
	(107, 'read_contacts', 'contacts', '2023-09-26 10:56:10', '2023-09-26 10:56:10'),
	(108, 'edit_contacts', 'contacts', '2023-09-26 10:56:10', '2023-09-26 10:56:10'),
	(109, 'add_contacts', 'contacts', '2023-09-26 10:56:10', '2023-09-26 10:56:10'),
	(110, 'delete_contacts', 'contacts', '2023-09-26 10:56:10', '2023-09-26 10:56:10'),
	(111, 'browse_languages', 'languages', '2023-11-03 21:26:39', '2023-11-03 21:26:39'),
	(112, 'read_languages', 'languages', '2023-11-03 21:26:39', '2023-11-03 21:26:39'),
	(113, 'edit_languages', 'languages', '2023-11-03 21:26:39', '2023-11-03 21:26:39'),
	(114, 'add_languages', 'languages', '2023-11-03 21:26:39', '2023-11-03 21:26:39'),
	(115, 'delete_languages', 'languages', '2023-11-03 21:26:39', '2023-11-03 21:26:39'),
	(116, 'browse_emails', 'emails', '2024-03-31 14:26:21', '2024-03-31 14:26:21'),
	(117, 'read_emails', 'emails', '2024-03-31 14:26:21', '2024-03-31 14:26:21'),
	(118, 'edit_emails', 'emails', '2024-03-31 14:26:21', '2024-03-31 14:26:21'),
	(119, 'add_emails', 'emails', '2024-03-31 14:26:21', '2024-03-31 14:26:21'),
	(120, 'delete_emails', 'emails', '2024-03-31 14:26:21', '2024-03-31 14:26:21');

-- Dumping structure for table ticket.permission_role
CREATE TABLE IF NOT EXISTS `permission_role` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_permission_id_index` (`permission_id`),
  KEY `permission_role_role_id_index` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.permission_role: ~118 rows (approximately)
INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
	(1, 1),
	(2, 1),
	(3, 1),
	(4, 1),
	(5, 1),
	(6, 1),
	(7, 1),
	(8, 1),
	(9, 1),
	(10, 1),
	(11, 1),
	(12, 1),
	(13, 1),
	(14, 1),
	(15, 1),
	(16, 1),
	(17, 1),
	(18, 1),
	(19, 1),
	(20, 1),
	(21, 1),
	(22, 1),
	(23, 1),
	(24, 1),
	(25, 1),
	(26, 1),
	(27, 1),
	(28, 1),
	(29, 1),
	(30, 1),
	(31, 1),
	(32, 1),
	(33, 1),
	(34, 1),
	(35, 1),
	(36, 1),
	(37, 1),
	(38, 1),
	(39, 1),
	(40, 1),
	(41, 1),
	(42, 1),
	(43, 1),
	(44, 1),
	(45, 1),
	(46, 1),
	(47, 1),
	(48, 1),
	(49, 1),
	(50, 1),
	(51, 1),
	(52, 1),
	(53, 1),
	(54, 1),
	(55, 1),
	(56, 1),
	(57, 1),
	(58, 1),
	(59, 1),
	(60, 1),
	(61, 1),
	(62, 1),
	(63, 1),
	(64, 1),
	(65, 1),
	(66, 1),
	(68, 1),
	(69, 1),
	(70, 1),
	(71, 1),
	(72, 1),
	(73, 1),
	(74, 1),
	(75, 1),
	(76, 1),
	(77, 1),
	(78, 1),
	(79, 1),
	(80, 1),
	(81, 1),
	(82, 1),
	(83, 1),
	(84, 1),
	(85, 1),
	(86, 1),
	(87, 1),
	(88, 1),
	(89, 1),
	(91, 1),
	(92, 1),
	(93, 1),
	(94, 1),
	(95, 1),
	(96, 1),
	(97, 1),
	(98, 1),
	(99, 1),
	(100, 1),
	(101, 1),
	(102, 1),
	(103, 1),
	(104, 1),
	(105, 1),
	(106, 1),
	(107, 1),
	(108, 1),
	(109, 1),
	(110, 1),
	(111, 1),
	(112, 1),
	(113, 1),
	(114, 1),
	(115, 1),
	(116, 1),
	(117, 1),
	(118, 1),
	(119, 1),
	(120, 1);

-- Dumping structure for table ticket.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table ticket.posts
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `author_id` int NOT NULL,
  `category_id` int DEFAULT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `excerpt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `meta_keywords` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('PUBLISHED','DRAFT','PENDING') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'DRAFT',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `posts_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.posts: ~4 rows (approximately)
INSERT INTO `posts` (`id`, `author_id`, `category_id`, `title`, `seo_title`, `excerpt`, `body`, `image`, `slug`, `meta_description`, `meta_keywords`, `status`, `featured`, `created_at`, `updated_at`) VALUES
	(5, 2, 1, 'Hvor skal man tage hen på ferie og hvor skal man spise?', NULL, 'Hvor skal man tage på ferie og hvor skal man spise?', '<p>Vi alle har brug for en pause fra hverdagen.&nbsp;</p>\r\n<p>Men hvad skal man g&oslash;re? hvor skal man tilbringe den sparsomme tid?</p>\r\n<p>Hos Halaldeals har vi unikke tilbud til dem, som &oslash;nsker at berige deres dagligdag med en oplevelse, hvor de kan nyde en bid mad eller f&aring; en oplevelse, som er halal. N&aring;r vi siger halal, s&aring; betyder det eksempelvis at maden vil v&aelig;re halal og det er ogs&aring; en stor del af selve oplevelsen.</p>\r\n<p>Tilmeld dig vores nyhedsbrev og berig dig selv med nye oplevelser som vi l&oslash;bende vil opdatere dig med.</p>\r\n<p>&nbsp;</p>\r\n<p>mvh</p>\r\n<p>Halaldeals.dk</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>', 'posts/March2024/l7SOp6OsIPs51UTKQotx.jpeg', 'hvor-skal-man-tage-hen-pa-ferie-og-hvor-skal-man-spise', NULL, NULL, 'PUBLISHED', 1, '2024-03-23 14:48:29', '2024-03-23 15:19:47'),
	(6, 2, 2, 'Er du en globetrotter?', NULL, NULL, '<p><strong>Muslimske Globetrottere: Fra Ibn Battuta til Nutidens Eventyrere</strong></p>\r\n<p>At rejse har altid v&aelig;ret en m&aring;de for mennesker at opdage og forst&aring; verden p&aring;. Det er en kilde til viden, berigelse og &aring;ndelig v&aelig;kst. I dag har vi privilegiet at have utallige muligheder for at udforske nye steder og kulturer, hvilket &aring;bner d&oslash;re til erfaringer, der er lige s&aring; v&aelig;rdifulde som dem, muslimske eventyrere som Ibn Battuta havde i fortiden.</p>\r\n<p><strong>Ibn Battuta: Den Store Rejsende</strong></p>\r\n<p>Lad os starte med en af de mest ikoniske muslimske rejsende gennem tiderne - Ibn Battuta. Han blev f&oslash;dt i Marokko i det 14. &aring;rhundrede og begav sig ud p&aring; en utrolig rejse, der strakte sig over 75.000 kilometer og inkluderede bes&oslash;g i mere end 40 lande. Hans rejse begyndte som en pilgrimsrejse til Mekka, men hans eventyrlyst f&oslash;rte ham til at udforske hele den kendte verden p&aring; det tidspunkt. Han nedskrev sine oplevelser i v&aelig;rket "Rihla," der stadig betragtes som en uvurderlig kilde til historisk og kulturel viden.</p>\r\n<p>Ibn Battutas rejse var en bem&aelig;rkelsesv&aelig;rdig pr&aelig;station p&aring; den tid, da det kr&aelig;vede en enorm viljestyrke og mod at udforske det ukendte. Han m&oslash;dte forskellige kulturer, l&aelig;rte nye sprog og indgik venskaber, der var afg&oslash;rende for hans overlevelse. Hans rejse er en p&aring;mindelse om, at selv i en tid med begr&aelig;nsede teknologiske ressourcer og transportmuligheder, var &oslash;nsket om at udforske og opdage en st&aelig;rk drivkraft.</p>\r\n<p><img title="Halaldeals.dk Ibn bin Battuta" src="http://halaldeals.dk/storage/pages/October2023/Ibn bin battura.jpg" alt="" width="516" height="800"></p>\r\n<p>Ibn Battuta delte scenen med flere andre, der ligeledes tog p&aring; sp&aelig;ndende rejser og berigede verden med deres oplevelser. Lad os udforske nogle af dem:</p>\r\n<p><strong>1. Ibn Battuta (1304-1368):</strong> Selvf&oslash;lgelig starter vi med Ibn Battuta selv. Hans utrolige rejse begyndte som en pilgrimsrejse til Mekka, men hans eventyrlyst f&oslash;rte ham p&aring; en 30-&aring;rig rejse, der f&oslash;rte ham til steder som Marokko, Indien, Kina og flere afrikanske lande. Hans livsfort&aelig;lling i v&aelig;rket "Rihla" er stadig en ut&oslash;mmelig kilde til historisk og kulturel viden.</p>\r\n<p><strong>2. Mansa Musa (1280-1337):</strong> Mansa Musa var en ber&oslash;mt muslimsk konge i Mali-riget. Han er kendt for sin legendariske pilgrimsrejse til Mekka, hvor han f&oslash;rte en enorm karavane, der bar store m&aelig;ngder guld, hvilket f&oslash;rte til en &oslash;konomisk katastrofe i de omr&aring;der, han passerede. Ikke desto mindre er han kendt for at have udbredt islam i Vestafrika og for sin velg&oslash;renhed.</p>\r\n<p><strong>3. Ibn Jubayr (1145-1217):</strong> Ibn Jubayr, en anden bem&aelig;rkelsesv&aelig;rdig muslimsk rejsende, foretog en rejse fra Spanien til Mekka i det 12. &aring;rhundrede.&nbsp;</p>\r\n<p>Disse eksempler viser, at muslimske eventyrere har haft sp&aelig;ndende historier, der har bidraget til den globale historie. De har rejst i alle retninger, krydset gr&aelig;nser og kulturer og inspireret os til at udforske verden p&aring; nye m&aring;der.</p>\r\n<p>I dag har b&aring;de m&aelig;nd og kvinder, unge og gamle, muligheden for at tage p&aring; eventyr som disse store muslimske rejsende. Moderne teknologi og rejsemuligheder g&oslash;r det lettere end nogensinde f&oslash;r at udforske verden. S&aring; lad os lade os inspirere af disse eventyrere og f&oslash;lge vores egne dr&oslash;mme om at opdage de skatte, der venter i verdenen uden for vores d&oslash;re. Rejs, opdag og lev livet fuldt ud - som muslimer og som borgere af en mangfoldig og vidunderlig planet.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>Nutidens Muligheder for Opdagelse</strong></p>\r\n<p>I dag har vi adgang til utallige muligheder for at f&oslash;lge i fodsporene p&aring; eventyrere som Ibn Battuta. Moderne teknologi og globalisering har gjort det muligt for os at rejse lettere og mere bekvemt end nogensinde f&oslash;r. Der er flyrejser, hurtigtog og internettet, der g&oslash;r det muligt for os at planl&aelig;gge vores rejser, finde information om destinationer og endda booke hoteller og restaurantreservationer fra vores smartphones.</p>\r\n<p><strong>Hvorfor Vi Skal Rejse og Opdage</strong></p>\r\n<p>Rejser og opdagelse handler ikke kun om at se smukke steder og pr&oslash;ve l&aelig;kker mad. Det handler ogs&aring; om at udvide vores horisonter, fordybe vores forst&aring;else af verden og berige vores liv med nye perspektiver. N&aring;r vi udforsker forskellige kulturer, l&aelig;rer vi at v&aelig;rds&aelig;tte mangfoldigheden i Guds skaberv&aelig;rk.</p>\r\n<p>Desuden hj&aelig;lper rejser os med at skabe minder og oplevelser, der former os som individer. Vi l&aelig;rer at overvinde udfordringer, forst&aring;else og tolerance for andre kulturer og styrker vores tro p&aring;, at verden er en skattekiste fyldt med sk&oslash;nhed og underv&aelig;rker.</p>\r\n<p>I dag, som muslimske rejsende, har vi mulighed for at udforske verden og f&oslash;lge i fodsporene p&aring; tidligere eventyrere som Ibn Battuta. Moderne teknologi og rejsefaciliteter har gjort det lettere end nogensinde f&oslash;r. S&aring; lad os pakke vores tasker, lade vores nysgerrighed og eventyrlyst guide os, og begive os ud p&aring; vores eget episke eventyr for at opdage og forst&aring; den vidunderlige verden, der venter p&aring; os derude. Rejs, opdag og lev livet fuldt ud - det er en invitation, vi b&oslash;r omfavne med &aring;bne arme.</p>\r\n<p>Find vores tilbud p&aring; rejser HER</p>', 'posts/March2024/w5CUluok7iitvTPtbsHf.png', 'er-du-en-globetrotter', NULL, NULL, 'PUBLISHED', 0, '2024-03-23 15:53:59', '2024-03-23 15:53:59'),
	(7, 2, 2, 'Spis rejs og lev', NULL, NULL, '<p><strong>Opdag Verden med Halaldeals.dk: Rejs, Spis og Lev Livet som Muslim</strong></p>\r\n<p>Rejs, spis og lev - tre ord, der indeholder n&oslash;glen til at udforske verden. Hos Halaldeals.dk &aring;bner vi d&oslash;ren til sp&aelig;ndende muligheder for dig, der s&oslash;ger at berige dit liv med uforglemmelige oplevelser og tilbud, der ikke g&aring;r p&aring; kompromis med din overbevisning. Vores tilbud kan inkludere alt fra eksklusive restaurantoplevelser til fantastiske rejser og hotelophold.</p>\r\n<p><strong>Rejser, der N&aelig;rer Din Sj&aelig;l</strong></p>\r\n<p>Rejser er en mulighed for at udforske verden, forst&aring; forskellige kulturer og fordybe din forbindelse til alt hvad vores skaber har skabt. Halaldeals.dk tilbyder skr&aelig;ddersyede rejseoplevelser, der er skr&aelig;ddersyet prim&aelig;rt til muslimske rejsende. Uanset om du dr&oslash;mmer om en pilgrimsrejse til Mekka eller Medina eller en eventyrlig tur til en eksotisk destination som Bali, s&aring; har vi unikke rejsetilbud, der passer til dine behov.&nbsp;</p>\r\n<p><img title="Halaldeals.dk Blog 1. Rejs spis og lev" src="http://halaldeals.dk/storage/pages/October2023/pexels-beyzanur-k-18721555.jpg" alt="" width="1800" height="2700"></p>\r\n<p><strong>Smag P&aring; Verden med Halalmad</strong></p>\r\n<p>En af de mest forn&oslash;jelige aspekter ved at rejse er at udforske forskellige k&oslash;kkener. Vores deals inkluderer eksklusive aftaler med restauranter, der serverer autentisk og l&aelig;kker mad, som er halal. Uanset om det er gourmetretter i Dubai, traditionelle smagsoplevelser i Tyrkiet eller en gourmet restaurant i indre K&oslash;benhavn, vil du opleve en verden af kulinariske forn&oslash;jelser uden at bekymre dig om det du f&aring;r serveret er halal.</p>\r\n<p><strong>Komfortable Hotelophold for Kvinder</strong></p>\r\n<p>Vi forst&aring;r, at det som muslimsk kvinde kan v&aelig;re udfordrende at finde komfortable og respektfulde hotelophold. Derfor har Halaldeals.dk indg&aring;et aftaler med hoteller, der prioriterer kvindelige g&aelig;sters komfort og sikkerhed. S&aring; uanset om du planl&aelig;gger en afslappende ferie eller forretningsrejse, kan du stole p&aring; vores tilbud til kvinder.</p>\r\n<p><strong>Hvorfor Rejse, Spis og Lev som Muslim?</strong></p>\r\n<p>At rejse, spise og leve som muslim handler ikke kun om at opfylde religi&oslash;se forpligtelser; det handler om at berige dit liv og din sj&aelig;l. Det handler om at omfavne den mangfoldighed, som Gud har skabt i verden. Det handler om at skabe minder og oplevelser, der vil forme dig og dit syn p&aring; verden.</p>\r\n<p>S&aring; hvorfor skal du rejse, spise og leve som muslim? Fordi det er en invitation til at udforske verden p&aring; dine egne vilk&aring;r, i overensstemmelse med dine v&aelig;rdier og tro. Halaldeals.dk er her for at hj&aelig;lpe dig med at g&oslash;re dette til virkelighed. S&aring; g&aring; ikke glip af de unikke tilbud, der kan give dig mulighed for at rejse, smage, og leve livet som muslim.</p>\r\n<p><strong>Slutningen p&aring; Rejsen - Begyndelsen p&aring; Livet</strong></p>\r\n<p>Rejser, spisning og livet som muslim er mere end bare aktiviteter; det er en livsfilosofi. Det er en m&aring;de at fejre din tro og fordybe din forst&aring;else af verden og dine medmennesker. Halaldeals.dk er din partner p&aring; denne rejse, der &aring;bner d&oslash;rene til en verden af muligheder, hvor du kan leve dit liv i overensstemmelse med dine v&aelig;rdier og tro.</p>\r\n<p>S&aring; lad os sammen udforske verden, smage dens skatte og leve vores liv fuldt ud som muslimer. Rejs, spis og lev - det er ikke blot en opfordring, det er en invitation til at omfavne livets sk&oslash;nhed og mangfoldighed med Halaldeals.dk.</p>', 'posts/March2024/iL7IDstayS8nHEwgnASX.jpg', 'spis-rejs-og-lev', NULL, NULL, 'PUBLISHED', 0, '2024-03-23 15:56:05', '2024-03-23 15:56:05'),
	(8, 2, 1, 'Halal hvad er det?', NULL, NULL, '<p><strong>Betydning af Halal Mad: Kilden til Tro og Tillid</strong></p>\r\n<p>Halal mad er ikke blot en kostplan, det er en grundpille i den muslimske livsstil. Det indeb&aelig;rer at spise f&oslash;devarer og drikkevarer, der er tilladte i henhold til islamiske love og retningslinjer, og det er mere end blot en religi&oslash;s praksis - det er en livsstil og et udtryk for tro og respekt for Gud. Lad os udforske, hvorfor halal mad er s&aring; vigtig for muslimer og hvordan Halaldeals.dk samarbejder med restauranter for at sikre, at halalforordningerne overholdes.</p>\r\n<p><strong>Halal Mad og Troen</strong></p>\r\n<p>For muslimer er det at spise halal mad en m&aring;de at leve i overensstemmelse med deres religi&oslash;se overbevisninger. Det er baseret p&aring; de klare retningslinjer i koranen og profetens hadith, der specificerer, hvilke f&oslash;devarer der er lovlige (halal) og hvilke der er forbudte (haram). At f&oslash;lge disse retningslinjer er et udtryk for lydighed mod Gud og en m&aring;de at udtrykke taknemmelighed for Hans forsyning og gaver. J&oslash;dedommen f&oslash;lger de samme principper, som kaldes kosher, istedet for halal.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>Sikkerhed og Tillid i Halal Mad</strong></p>\r\n<p>Halal mad handler ikke kun om at spise korrekte f&oslash;devarer, men det omfatter ogs&aring;, hvordan maden tilberedes. En vigtig del af halalforordningerne er, at maden skal tilberedes og h&aring;ndteres p&aring; en m&aring;de, der overholder rene og hygiejniske standarder. Dette garanterer ikke kun, at maden er tilladt if&oslash;lge islamisk lov, men det sikrer ogs&aring;, at den er sund og sikker at indtage.</p>\r\n<p>For muslimer er sp&oslash;rgsm&aring;let om tillid og sikkerhed i maden vigtig. N&aring;r de spiser p&aring; restauranter, &oslash;nsker de at v&aelig;re sikre p&aring;, at de ikke kun spiser halal mad, men at den ogs&aring; er blevet tilberedt korrekt og uden krydsforurening med haram ingredienser. Det er her, Halaldeals.dk kommer ind i billedet.</p>\r\n<p><strong>Halaldeals.dk og Kvalitetskontrol</strong></p>\r\n<p>Halaldeals.dk har skabt en platform, der samarbejder med restauranter og spisesteder, der forpligter sig til at levere &aelig;gte halal mad. Dette betyder, at de kun bruger halal ingredienser og f&oslash;lger strenge retningslinjer indenfor tilberedning og h&aring;ndtering af maden. Dette sikrer, at muslimer, der v&aelig;lger at spise p&aring; disse steder, kan g&oslash;re det med tillid og fred i sindet.</p>\r\n<p>Vi hos Halaldeals.dk forpligter os til at finde spisesteder til jer, der &oslash;nsker at nyde autentisk og velsmagende mad. Dette inkluderer alt fra eksotiske retter fra Mellem&oslash;sten til asiatiske delikatesser og moderne fusionk&oslash;kkener.&nbsp;</p>\r\n<p><strong>Forskel p&aring; 100% halal og delvis halal</strong></p>\r\n<p>&nbsp;</p>', 'posts/March2024/CRFq503HYUPkY4osGrfS.jpg', 'halal-hvad-er-det', NULL, NULL, 'PUBLISHED', 0, '2024-03-23 15:57:23', '2024-03-23 15:57:23');

-- Dumping structure for table ticket.prodcats
CREATE TABLE IF NOT EXISTS `prodcats` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` bigint unsigned NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `prodcats_shop_id_foreign` (`shop_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.prodcats: ~5 rows (approximately)
INSERT INTO `prodcats` (`id`, `shop_id`, `name`, `logo`, `slug`, `parent_id`, `created_at`, `updated_at`) VALUES
	(1, 5, 'Restaurant', 'cat/1.png', 'Restaurant', NULL, NULL, '2023-10-20 14:04:39'),
	(2, 4, 'Hotelophold', 'cat/2.png', 'Hotelophold', NULL, NULL, '2023-10-20 14:05:00'),
	(3, 1, 'Skønhed og velvære', 'cat/3.png', 'Skønhed og velvære', NULL, NULL, '2023-10-20 14:05:20'),
	(4, 3, 'Familie oplevelser', 'cat/4.png', 'Familie oplevelser', NULL, NULL, '2023-10-20 14:05:53'),
	(5, 4, 'Styrk dit indre jeg', 'cat/5.png', 'Styrke dit indre jeg', NULL, NULL, '2023-10-20 14:06:31');

-- Dumping structure for table ticket.prodcat_product
CREATE TABLE IF NOT EXISTS `prodcat_product` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `prodcat_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `prodcat_product_product_id_foreign` (`product_id`),
  KEY `prodcat_product_prodcat_id_foreign` (`prodcat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.prodcat_product: ~13 rows (approximately)
INSERT INTO `prodcat_product` (`id`, `product_id`, `prodcat_id`, `created_at`, `updated_at`) VALUES
	(3, 63, 2, '2023-09-12 02:11:43', '2023-09-12 02:11:43'),
	(4, 63, 4, '2023-09-12 02:11:43', '2023-09-12 02:11:43'),
	(8, 66, 2, '2023-09-14 04:21:04', '2023-09-14 04:21:04'),
	(11, 68, 3, '2023-09-19 05:27:22', '2023-09-19 05:27:22'),
	(12, 70, 4, NULL, NULL),
	(13, 70, 3, NULL, NULL),
	(14, 71, 1, NULL, NULL),
	(15, 74, 1, NULL, NULL),
	(16, 73, 5, NULL, NULL),
	(17, 72, 3, NULL, NULL),
	(18, 67, 2, NULL, NULL),
	(19, 75, 2, NULL, NULL),
	(20, 76, 1, NULL, NULL);

-- Dumping structure for table ticket.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` bigint unsigned DEFAULT NULL,
  `city_id` bigint DEFAULT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `short_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `amenities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `sku` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` int DEFAULT NULL,
  `views` bigint NOT NULL DEFAULT '0',
  `sale_price` int DEFAULT NULL,
  `total_sale` int DEFAULT NULL,
  `downloads` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `manage_stock` tinyint(1) NOT NULL DEFAULT '0',
  `quantity` int DEFAULT NULL,
  `weight` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dimensions` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating_count` int DEFAULT NULL,
  `parent_id` int DEFAULT NULL,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_code` bigint DEFAULT NULL,
  `vendor_price` decimal(10,0) DEFAULT NULL,
  `images` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `variations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `is_offer` tinyint DEFAULT NULL,
  `expired_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bestdeals` tinyint DEFAULT NULL,
  `event_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_host` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_start_date` timestamp NULL DEFAULT NULL,
  `event_end_date` timestamp NULL DEFAULT NULL,
  `last_date_of_purchase` timestamp NULL DEFAULT NULL,
  `event_location` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  KEY `products_shop_id_foreign` (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ticket.products: ~20 rows (approximately)
INSERT INTO `products` (`id`, `shop_id`, `city_id`, `name`, `slug`, `type`, `status`, `featured`, `description`, `short_description`, `amenities`, `sku`, `price`, `views`, `sale_price`, `total_sale`, `downloads`, `manage_stock`, `quantity`, `weight`, `dimensions`, `rating_count`, `parent_id`, `image`, `post_code`, `vendor_price`, `images`, `variations`, `is_offer`, `expired_at`, `created_at`, `updated_at`, `bestdeals`, `event_name`, `event_host`, `event_start_date`, `event_end_date`, `last_date_of_purchase`, `event_location`) VALUES
	(97, NULL, NULL, 'Comic-Con International Ticket', 'comic-con-international-66a2b24fcf6c9', NULL, 1, 1, 'Ut non quis ut eum. Non ipsam ad omnis qui. Tempore aut sapiente hic impedit unde optio.\n\nMagnam accusantium excepturi sint. Ullam sequi magni et quidem. Dolores eum non dignissimos impedit occaecati sed. Temporibus qui perspiciatis et est totam dicta.\n\nLabore rerum rerum error sit saepe rerum quis. Fugiat velit fugit qui est maxime iusto saepe. Minima esse hic explicabo quae culpa blanditiis est error. Beatae enim qui voluptatibus earum recusandae nostrum eveniet.', 'Sit quas corrupti ipsum ut vel. Eum et vero animi error. Aut dicta odit nam.\n\nVeniam laboriosam ut quis aspernatur earum. Suscipit non aliquid architecto vel numquam consequatur. Corrupti et est ut tenetur possimus doloremque non.\n\nExpedita placeat eum occaecati nemo qui officia. Deserunt aut fugiat quia quis sunt beatae voluptatem. Labore totam nulla explicabo dolore. Voluptatibus ut incidunt et deserunt.', NULL, NULL, 120, 0, 100, NULL, NULL, 0, 99, NULL, NULL, NULL, NULL, 'product/one.jpg', NULL, NULL, NULL, NULL, NULL, '2024-07-26 12:50:33', '2024-07-25 14:15:11', '2024-07-26 06:50:33', NULL, 'Comic-Con International', 'Funk-Torphy', '2024-08-04 14:15:11', '2024-08-06 14:15:11', '2024-08-02 14:15:11', 'West Adaline'),
	(98, NULL, NULL, 'Lollapalooza Ticket', 'lollapalooza-66a2b24fcf972', NULL, 1, 1, 'Et illum et dolorem debitis. Quos illum vel est molestiae optio qui quisquam. Autem dolorem possimus nihil id est.\n\nDelectus totam ut eligendi numquam voluptatum repellat similique. Vel in iure nihil ipsa perspiciatis. Ullam veniam quibusdam veritatis.\n\nNon commodi nam quo et velit debitis deserunt. Doloremque voluptatibus modi et ratione debitis.', 'Amet nemo optio voluptatum perferendis pariatur cum neque. Illo consectetur est assumenda sequi expedita nobis sed. Sed et quia architecto aut quo. Temporibus alias eaque non sint quo minus. Laborum eum cum ut et.\n\nAutem beatae quo earum. Eligendi porro nisi totam voluptas. Velit perferendis qui fuga esse minus quia eos nemo. Voluptatem voluptatem tempora id ipsum.\n\nIllum rerum tenetur aut repellat in. Ipsam et occaecati omnis qui. Cumque id eligendi veniam deserunt id debitis. Exercitationem alias exercitationem tenetur atque aspernatur.', NULL, NULL, 120, 0, 100, NULL, NULL, 0, 100, NULL, NULL, NULL, NULL, 'product/two.jpg', NULL, NULL, NULL, NULL, NULL, '2024-07-25 20:15:11', '2024-07-25 14:15:11', '2024-07-25 14:15:11', NULL, 'Lollapalooza', 'Ledner Group', '2024-08-04 14:15:11', '2024-08-06 14:15:11', '2024-08-02 14:15:11', 'Beahanfurt'),
	(99, NULL, NULL, 'Summerfest Ticket', 'summerfest-66a2b24fcfac4', NULL, 1, 1, 'Qui vel cupiditate voluptas incidunt excepturi omnis aliquid voluptatem. In aut corrupti totam nobis voluptatem alias. Autem distinctio et et quia. Enim mollitia delectus nobis esse ab culpa voluptate.\n\nDolore aliquid voluptas explicabo quas excepturi harum. Est autem sit necessitatibus nisi ipsa consequatur. Consequatur omnis id et. Tempore vel ut libero dolores.\n\nAliquid minus vero vel enim quia sed explicabo. Officiis quod est blanditiis et officia. Distinctio ad qui omnis deleniti atque.', 'Fuga quam natus repudiandae occaecati cumque quisquam. Consectetur rerum esse qui quaerat voluptas aut quo deleniti. Ut facilis hic commodi dolore rerum. Natus illum molestias a ullam ducimus. Aspernatur aliquid hic voluptatem et.\n\nError ipsum inventore quisquam est laudantium. Sunt est a quam et impedit. Ducimus nulla omnis est optio rerum voluptas error.\n\nEst facilis voluptate quae consequatur dolorem modi sit. Ipsam debitis ratione corrupti ut eius. Consequatur amet unde consectetur odit ut consequatur error quos.', NULL, NULL, 120, 0, 100, NULL, NULL, 0, 99, NULL, NULL, NULL, NULL, 'product/four.jpg', NULL, NULL, NULL, NULL, NULL, '2024-07-26 17:16:08', '2024-07-25 14:15:11', '2024-07-26 11:16:08', NULL, 'Summerfest', 'Crona, Kunze and Dickinson', '2024-08-04 14:15:11', '2024-08-06 14:15:11', '2024-08-02 14:15:11', 'Soledadstad'),
	(100, NULL, NULL, 'DEF CON Ticket', 'def-con-66a2b24fcfc28', NULL, 1, 1, 'Quisquam qui unde molestias et error. Libero esse est maxime ipsum repudiandae officia. Aspernatur nulla dolor aut molestiae atque minima nemo.\n\nMaiores sint cupiditate excepturi rerum eius. Dolore totam fugit et ab et nostrum odit. Est et nisi ipsum voluptatem adipisci blanditiis corporis. Dolore nulla qui adipisci accusamus provident id.\n\nEligendi assumenda aspernatur omnis sit. Et autem ea nulla at eligendi consequatur. Architecto assumenda quisquam consequatur.', 'Dolorum numquam eum doloremque. Asperiores ut magnam quia quia ullam hic consequatur. Possimus debitis iste consequatur sint quidem ea. Harum quidem qui laborum assumenda delectus omnis laboriosam.\n\nOdit ab quae quasi sed minima. Perferendis veritatis ea sapiente id possimus qui optio. Corrupti consequatur quia vero excepturi. Officiis dolores eos corporis illum provident.\n\nIn repudiandae omnis amet dolor consectetur. Libero et et ea. In iure earum error.', NULL, NULL, 120, 0, 100, NULL, NULL, 0, 100, NULL, NULL, NULL, NULL, 'product/two.jpg', NULL, NULL, NULL, NULL, NULL, '2024-07-25 20:15:11', '2024-07-25 14:15:11', '2024-07-25 14:15:11', NULL, 'DEF CON', 'Gutmann LLC', '2024-08-04 14:15:11', '2024-08-06 14:15:11', '2024-08-02 14:15:11', 'Port Salvador'),
	(101, NULL, NULL, 'Google I/O Ticket', 'google-io-66a2b24fcfd68', NULL, 1, 1, 'Nisi unde sint est est ut est. Rerum ut aperiam quia ducimus optio minima. Quidem voluptatum ut in aut veritatis soluta ab.\n\nDeleniti qui labore doloremque fugit. Eaque sunt distinctio illum aut earum dicta sunt fuga. Voluptatem nisi quidem amet suscipit asperiores.\n\nAsperiores aut perferendis corrupti repellat fuga. Aut ad quis qui ipsum rem modi vitae quos. Ex dolores vero sed ullam est quia soluta. Itaque hic explicabo voluptates ea quo voluptas expedita.', 'Doloribus voluptatem corporis sint quis consectetur ipsam. Qui earum enim quibusdam explicabo. Itaque consequuntur minima non et temporibus deleniti doloribus.\n\nEt voluptatem et voluptatem. Excepturi ea hic recusandae aut magni voluptas. Earum distinctio dolorem autem et. Eius dolorum omnis aperiam omnis accusantium beatae ipsum magni.\n\nLabore accusamus tempore ea nemo qui distinctio harum. Doloremque omnis facilis aut dolor officia. Tempora doloremque nostrum perferendis rerum aliquid dolor nulla.', NULL, NULL, 120, 0, 100, NULL, NULL, 0, 100, NULL, NULL, NULL, NULL, 'product/four.jpg', NULL, NULL, NULL, NULL, NULL, '2024-07-25 20:15:11', '2024-07-25 14:15:11', '2024-07-25 14:15:11', NULL, 'Google I/O', 'Stamm, Satterfield and Bayer', '2024-08-04 14:15:11', '2024-08-06 14:15:11', '2024-08-02 14:15:11', 'Anyastad'),
	(102, NULL, NULL, 'Coachella Ticket', 'coachella-66a2b24fcfeb2', NULL, 1, 1, 'Nostrum at distinctio adipisci quidem laborum dolor voluptatem. Repellendus eius culpa et expedita eum. Architecto cupiditate ut sit magnam iure totam. Harum omnis facilis minus dolor modi.\n\nIpsam omnis saepe quod voluptatem. Accusamus sit voluptatem voluptas placeat ratione. Aperiam omnis eos est molestiae quis est inventore.\n\nId cumque aperiam velit dolorem aliquam consectetur fugit. Est maxime asperiores consequatur laboriosam. Et iste est sed consectetur aut amet.', 'Reprehenderit temporibus at ut et exercitationem quis voluptatem a. Et perspiciatis voluptatem excepturi et. Impedit magnam id eos molestias neque. Eius expedita consequatur suscipit et est libero.\n\nSit eum minima et. Sit mollitia et minus ea.\n\nExpedita asperiores nostrum molestias aut ducimus asperiores id. Mollitia fugiat nam et quia. Aut rerum dolores beatae consequatur recusandae. Mollitia ut corporis quia.', NULL, NULL, 120, 0, 100, NULL, NULL, 0, 100, NULL, NULL, NULL, NULL, 'product/four.jpg', NULL, NULL, NULL, NULL, NULL, '2024-07-25 20:15:11', '2024-07-25 14:15:11', '2024-07-25 14:15:11', NULL, 'Coachella', 'O\'Conner Group', '2024-08-04 14:15:11', '2024-08-06 14:15:11', '2024-08-02 14:15:11', 'Port Dedrickborough'),
	(103, NULL, NULL, 'Tomorrowland Ticket', 'tomorrowland-66a2b24fcfff4', NULL, 1, 1, 'Tempore labore quidem sed et harum cupiditate iure. Earum provident omnis quos odit.\n\nVitae est et doloribus est eos ut. Impedit accusantium vitae cumque nisi illo. Adipisci eaque nisi perspiciatis velit dolor. Rem vitae recusandae earum reprehenderit.\n\nLaborum ex odio enim temporibus tenetur architecto. Impedit quia omnis amet quis. Quas possimus enim maxime illo.', 'Voluptas beatae tenetur eligendi qui. Excepturi beatae nihil ut voluptas temporibus. Harum voluptate in aut numquam unde et.\n\nEt ut quis omnis consequatur omnis accusantium quas. Consectetur ea et quisquam temporibus. Eum est voluptate incidunt.\n\nVel exercitationem assumenda soluta voluptatem. Nihil at voluptas et nihil. Vero numquam dolor delectus laudantium provident sit quidem aperiam.', NULL, NULL, 120, 0, 100, NULL, NULL, 0, 100, NULL, NULL, NULL, NULL, 'product/one.jpg', NULL, NULL, NULL, NULL, NULL, '2024-07-25 20:15:11', '2024-07-25 14:15:11', '2024-07-25 14:15:11', NULL, 'Tomorrowland', 'Lakin-Mraz', '2024-08-04 14:15:11', '2024-08-06 14:15:11', '2024-08-02 14:15:11', 'Port Rylanstad'),
	(104, NULL, NULL, 'Tomorrowland Ticket', 'tomorrowland-66a2b24fd0117', NULL, 1, 1, 'Quas repellat ducimus eius natus repellat dolorem. Placeat dolorum ipsa porro maiores. Non aperiam nihil adipisci molestiae quas.\n\nEst placeat labore eius molestiae non est. Ut itaque corporis eius exercitationem totam iste enim. Et deleniti modi expedita voluptatem rem vero ex.\n\nPlaceat omnis et assumenda aut rem modi. Provident beatae et repellendus odit ea rerum. Enim quo ipsam praesentium amet tenetur voluptatem.', 'Nobis beatae et quisquam ea reprehenderit vel. Quidem esse natus nam sit.\n\nSoluta voluptatem exercitationem amet perferendis saepe rem eaque. Cupiditate doloremque dolor fugiat eos et odio quas.\n\nNihil quo eius illum dolor ut. Nostrum in repellat in accusantium aliquid. Officiis nostrum dolor minima totam maxime nemo animi ducimus.', NULL, NULL, 120, 0, 100, NULL, NULL, 0, 100, NULL, NULL, NULL, NULL, 'product/two.jpg', NULL, NULL, NULL, NULL, NULL, '2024-07-25 20:15:11', '2024-07-25 14:15:11', '2024-07-25 14:15:11', NULL, 'Tomorrowland', 'Terry PLC', '2024-08-04 14:15:11', '2024-08-06 14:15:11', '2024-08-02 14:15:11', 'East Neldaville'),
	(105, NULL, NULL, 'Summerfest Ticket', 'summerfest-66a2b24fd023a', NULL, 1, 1, 'Voluptates minus praesentium totam rerum accusamus rerum et. Sunt et quisquam architecto autem et.\n\nSed adipisci fuga asperiores tempora doloremque hic maxime consequuntur. Molestiae dolore consequatur sit. Perspiciatis est esse quis aut qui sint incidunt. Sed et occaecati aliquam est voluptatibus et. Dolores dignissimos culpa fugiat amet beatae ut.\n\nEst eos officiis voluptatem in fuga sit distinctio. Autem quia qui aliquam. Quia at in itaque quis.', 'Sequi rerum quas esse modi. Optio laudantium temporibus maiores qui aut. Nihil aperiam dicta ducimus sit architecto et. Et qui quis eius.\n\nMolestias ad inventore dolor ullam blanditiis quo fugiat ut. Sit officiis harum sapiente. Perferendis sed unde veritatis aut aut quaerat. Magnam in quasi ut autem suscipit deleniti.\n\nMagni in ut recusandae inventore qui assumenda. Nisi voluptas quasi enim. Et ut vitae ipsam iusto tenetur doloremque. Debitis repudiandae a voluptatum impedit omnis architecto.', NULL, NULL, 120, 0, 100, NULL, NULL, 0, 100, NULL, NULL, NULL, NULL, 'product/four.jpg', NULL, NULL, NULL, NULL, NULL, '2024-07-25 20:15:11', '2024-07-25 14:15:11', '2024-07-25 14:15:11', NULL, 'Summerfest', 'Kuhic, Waelchi and Sporer', '2024-08-04 14:15:11', '2024-08-06 14:15:11', '2024-08-02 14:15:11', 'Emilianoburgh'),
	(106, NULL, NULL, 'Venice Biennale Ticket', 'venice-biennale-66a2b24fd038a', NULL, 1, 1, 'Rerum et soluta aut quis nisi illum optio. Sint dolores assumenda quas neque perspiciatis suscipit quo. Porro asperiores ea illum soluta qui.\n\nAssumenda repudiandae perspiciatis dolor voluptas. Laborum in odit facilis cumque et minima eaque sapiente. Nam omnis soluta est molestiae fugiat aliquam perferendis.\n\nCumque nihil iure quia non vel. Rerum sit et enim enim vero id in. Rerum saepe doloribus nam omnis vero aut hic. Aut nulla sapiente omnis laudantium maxime.', 'Beatae et minima fuga. Sit quaerat ullam consequuntur quam. Praesentium et aut deleniti fugit ratione quia id numquam. Tempore repellat facilis minus provident omnis error sapiente.\n\nOccaecati illum illo et sunt et facere voluptatem. Qui veritatis eaque maxime consequatur minus at. Vitae blanditiis dolores vitae alias dolorem eos. Deleniti enim similique tenetur atque eos ea.\n\nVitae eum dolorem nam vero enim ipsum vero. Quo quibusdam maiores unde sequi magnam corrupti.', NULL, NULL, 120, 0, 100, NULL, NULL, 0, 99, NULL, NULL, NULL, NULL, 'product/three.jpg', NULL, NULL, NULL, NULL, NULL, '2024-07-26 12:50:33', '2024-07-25 14:15:11', '2024-07-26 06:50:33', NULL, 'Venice Biennale', 'Lehner-Ondricka', '2024-08-04 14:15:11', '2024-08-06 14:15:11', '2024-08-02 14:15:11', 'Zulauftown'),
	(107, NULL, NULL, 'SXSW Ticket', 'sxsw-66a2b24fd04d5', NULL, 1, 1, 'Totam impedit est ea sit libero nisi. Dolorem ratione omnis veritatis et aut. Quia tenetur consequatur voluptatibus dolores.\n\nDolore harum excepturi aut qui recusandae. Assumenda libero dicta ea ipsum modi autem illo. Blanditiis veniam provident atque ut provident recusandae adipisci. Tempora error molestiae eveniet ducimus et vero deleniti. A qui omnis cumque eaque est.\n\nDignissimos quidem porro vitae quidem. Aspernatur ea aut qui corporis possimus laborum libero sed. Voluptatem ipsum sunt repellendus commodi quis atque earum. Voluptatem rerum dolorem consequatur dolor nemo quia non.', 'Eum molestias qui excepturi optio perspiciatis assumenda voluptates. Sed sed consequuntur similique quia. Aspernatur perspiciatis voluptas eius accusantium at exercitationem quod.\n\nSed eaque quia consequatur voluptate. Deleniti ut hic nostrum eligendi qui earum velit. Amet voluptate veniam quas quia deserunt.\n\nRerum ipsa ducimus deserunt molestias ad delectus. Neque suscipit sed neque soluta voluptatem eos voluptates quod. Sapiente magnam sequi sed facilis inventore. Incidunt sequi voluptas quae qui aut eligendi. Modi aut rem quia dolorem quos.', NULL, NULL, 120, 0, 100, NULL, NULL, 0, 100, NULL, NULL, NULL, NULL, 'product/four.jpg', NULL, NULL, NULL, NULL, NULL, '2024-07-25 20:15:11', '2024-07-25 14:15:11', '2024-07-25 14:15:11', NULL, 'SXSW', 'Jerde-Turcotte', '2024-08-04 14:15:11', '2024-08-06 14:15:11', '2024-08-02 14:15:11', 'Bechtelarchester'),
	(108, NULL, NULL, 'TED Conference Ticket', 'ted-conference-66a2b24fd0629', NULL, 1, 1, 'Ab sunt velit ea voluptatem omnis fugit praesentium. Voluptas ut quia rerum. Sint ipsum occaecati excepturi sit. Quidem animi fuga qui rerum.\n\nUt sit suscipit ipsa quisquam corporis possimus. Quam quasi molestiae laboriosam aut. Animi voluptatibus unde est sunt molestias rem et. Voluptatem doloribus mollitia maiores vitae voluptatem.\n\nDolores sint a numquam. Aliquam suscipit esse facilis occaecati aspernatur. Repellendus ut qui dolorum rerum in et qui.', 'Qui sunt voluptas quae aut nam sed. Corporis qui omnis repellendus fugit ad repudiandae. Tempora et molestias sed error consequuntur veniam. Eos ducimus dolores ducimus et pariatur hic.\n\nImpedit veritatis accusamus corrupti. Minus dolorum non dolore ad.\n\nDolorem recusandae rerum quis vero praesentium ratione rerum. Quae nostrum ut molestiae ut quis tenetur ut.', NULL, NULL, 120, 0, 100, NULL, NULL, 0, 100, NULL, NULL, NULL, NULL, 'product/two.jpg', NULL, NULL, NULL, NULL, NULL, '2024-07-25 20:15:11', '2024-07-25 14:15:11', '2024-07-25 14:15:11', NULL, 'TED Conference', 'Heaney-Pollich', '2024-08-04 14:15:11', '2024-08-06 14:15:11', '2024-08-02 14:15:11', 'Johnsmouth'),
	(109, NULL, NULL, 'TED Conference Ticket', 'ted-conference-66a2b24fd0750', NULL, 1, 1, 'Neque similique veritatis quia quis dolores. Voluptatibus ut consequatur adipisci quis. Ut velit eos inventore occaecati nihil inventore adipisci et.\n\nDolore est impedit sit ea aut consectetur. Explicabo quos itaque exercitationem. Numquam tempora pariatur laboriosam qui inventore. Et molestiae dolorem quo totam. Et est aut in illum illo suscipit qui.\n\nProvident soluta et asperiores ex molestias. Consequatur voluptatem quo in nulla atque minus. Illum nulla quia ea ut.', 'Magni aliquid possimus iusto. Voluptas omnis molestiae cumque ipsam. Sunt dolores ut quae aspernatur et voluptatem. Praesentium ad facilis et facere enim aut.\n\nVoluptatem fugiat dolore et aut aliquid. Quam laboriosam qui quis nobis quidem. Et laboriosam velit tenetur quia optio delectus vitae.\n\nEt vero quia deserunt excepturi architecto voluptate. Deserunt cumque sint est tempore eum quia. Nobis aut quia aut est esse ut velit.', NULL, NULL, 120, 0, 100, NULL, NULL, 0, 100, NULL, NULL, NULL, NULL, 'product/four.jpg', NULL, NULL, NULL, NULL, NULL, '2024-07-25 20:15:11', '2024-07-25 14:15:11', '2024-07-25 14:15:11', NULL, 'TED Conference', 'Leffler-Steuber', '2024-08-04 14:15:11', '2024-08-06 14:15:11', '2024-08-02 14:15:11', 'South Maximoland'),
	(110, NULL, NULL, 'DreamHack Ticket', 'dreamhack-66a2b24fd088d', NULL, 1, 1, 'Recusandae dolores dolorem eos. Sed corrupti asperiores aspernatur possimus. Et ut totam corrupti blanditiis error ratione doloribus voluptates.\n\nEt voluptatibus ea doloribus. Corporis molestiae rem odit fugiat. Nesciunt quam at voluptatibus eum fugit aliquam. Autem tempora ipsa molestias occaecati.\n\nOmnis voluptatem minima illum facilis. Nesciunt voluptatem qui assumenda maiores esse et. Libero aut deserunt qui temporibus. Voluptatibus eos eveniet esse ducimus aut.', 'Corrupti laborum fugiat modi ad saepe. Ea eos temporibus consequatur magni. Laudantium asperiores earum sunt sed nulla cupiditate qui. Rem autem dolor quia molestiae debitis.\n\nSint accusantium eveniet molestias consequatur. Debitis perspiciatis excepturi dolor ducimus. Voluptatem id non corrupti enim tenetur veniam non quia.\n\nAutem aut aut similique iusto nesciunt id at sit. Quod itaque fugiat reprehenderit atque quo quia ad. Sed repellat asperiores id eum iure fuga tempora dolorum. Est placeat sint culpa natus nam modi.', NULL, NULL, 120, 0, 100, NULL, NULL, 0, 99, NULL, NULL, NULL, NULL, 'product/two.jpg', NULL, NULL, NULL, NULL, NULL, '2024-07-26 17:16:08', '2024-07-25 14:15:11', '2024-07-26 11:16:08', NULL, 'DreamHack', 'Corwin LLC', '2024-08-04 14:15:11', '2024-08-06 14:15:11', '2024-08-02 14:15:11', 'Mortimerhaven'),
	(111, NULL, NULL, 'DEF CON Ticket', 'def-con-66a2b24fd09cf', NULL, 1, 1, 'Aliquam dolor laboriosam autem et. Architecto ea recusandae omnis doloribus corporis tenetur. Ut labore qui et dolores. Cumque inventore et in animi expedita nihil.\n\nQuibusdam eligendi ad enim nemo amet cum eos. Rerum sapiente nostrum doloribus laboriosam qui. Mollitia quasi repudiandae architecto ex fugiat ad.\n\nIllo ut eius vitae aliquam aut vel. Aut ratione minus quam cumque asperiores. Rerum quis possimus tempora rem. Ut aliquid rerum officia totam quis libero illum. Voluptate eos numquam amet est mollitia dignissimos.', 'Sequi et harum qui omnis ut in. Excepturi soluta quos at sequi nihil non ratione. Quos praesentium ut delectus placeat consequuntur.\n\nSaepe rem sunt quia cumque ut. Veritatis non distinctio et eveniet quam consequatur quam. Sed est sunt aut nihil est. Aspernatur quae quo quia.\n\nError in repudiandae maiores aut optio. Iusto cumque nostrum vel et possimus quod quia. Magnam vel sed nemo mollitia atque ipsa nemo. Tempora rerum magnam modi eos et explicabo a nulla. Dolor consequatur et sed quos.', NULL, NULL, 120, 0, 100, NULL, NULL, 0, 100, NULL, NULL, NULL, NULL, 'product/three.jpg', NULL, NULL, NULL, NULL, NULL, '2024-07-25 20:15:11', '2024-07-25 14:15:11', '2024-07-25 14:15:11', NULL, 'DEF CON', 'Zulauf, Trantow and McDermott', '2024-08-04 14:15:11', '2024-08-06 14:15:11', '2024-08-02 14:15:11', 'Sofiaberg'),
	(112, NULL, NULL, 'HackMIT Ticket', 'hackmit-66a2b24fd0b29', NULL, 1, 1, 'Veritatis incidunt vel quam. Ex laborum delectus maiores. Et omnis voluptatem rerum. Fuga earum et officia ex fuga aliquid.\n\nVelit autem odio qui. Ad soluta illo recusandae ea illo possimus molestiae excepturi. Asperiores quaerat molestiae alias suscipit minus est iusto. Odio et magnam voluptas quia distinctio illo.\n\nDoloribus quia sint suscipit natus asperiores sed. Sunt earum deserunt cumque. Maxime nemo illo delectus nobis ut ea. Nostrum necessitatibus autem ullam quae sit culpa qui.', 'Impedit molestias deserunt vel non soluta ut. Ipsa sed repellendus quibusdam aliquid ut. Saepe omnis deserunt nisi sunt omnis distinctio. Sint occaecati libero repellendus illo ut nesciunt possimus.\n\nFuga iusto sed aut maxime impedit consequatur. Culpa ut sit quos est odio aut a.\n\nEt ut et corrupti esse illum rem ad. Architecto qui blanditiis voluptatem voluptatem eveniet. Eveniet cumque vel nobis harum sed reprehenderit est.', NULL, NULL, 120, 0, 100, NULL, NULL, 0, 100, NULL, NULL, NULL, NULL, 'product/four.jpg', NULL, NULL, NULL, NULL, NULL, '2024-07-25 20:15:11', '2024-07-25 14:15:11', '2024-07-25 14:15:11', NULL, 'HackMIT', 'Hoppe-Nikolaus', '2024-08-04 14:15:11', '2024-08-06 14:15:11', '2024-08-02 14:15:11', 'Elijahshire'),
	(113, NULL, NULL, 'Summerfest Ticket', 'summerfest-66a2b24fd0c73', NULL, 1, 1, 'Odit eius autem omnis ut cumque doloribus. Fugit et quos officia quia illum fuga repellendus. Sed esse rerum rerum enim molestias odit voluptatum.\n\nOccaecati recusandae aut placeat ut cupiditate est est. Reprehenderit sed cumque dolor sequi beatae recusandae. Harum pariatur ea et.\n\nVel sed et neque quia accusamus odio. Molestiae commodi ducimus quidem. Labore labore aut at autem. Inventore nulla ullam quia eligendi temporibus eaque occaecati ea. Corrupti dignissimos saepe illum molestias.', 'Aut ratione magni perferendis pariatur ut corrupti sint. Vel quas sint ut accusantium. Voluptas et quo soluta eius distinctio nemo. Qui ea et quam eos illum consectetur.\n\nInventore reiciendis quibusdam animi ipsum. Iste ad sed assumenda perspiciatis consectetur laudantium consectetur. Qui non cum quos assumenda fugit sunt. Debitis non atque tempore occaecati aut quis.\n\nNecessitatibus consequatur quaerat repellat voluptatibus cum et. Harum nesciunt omnis autem aut explicabo sapiente impedit ullam. Vitae doloribus adipisci laborum et. Voluptatem eos quia aperiam expedita.', NULL, NULL, 120, 0, 100, NULL, NULL, 0, 100, NULL, NULL, NULL, NULL, 'product/four.jpg', NULL, NULL, NULL, NULL, NULL, '2024-07-25 20:15:11', '2024-07-25 14:15:11', '2024-07-25 14:15:11', NULL, 'Summerfest', 'Crist-Olson', '2024-08-04 14:15:11', '2024-08-06 14:15:11', '2024-08-02 14:15:11', 'Buckridgeshire'),
	(114, NULL, NULL, 'Comic-Con International Ticket', 'comic-con-international-66a2b24fd0dbf', NULL, 1, 1, 'Quaerat necessitatibus doloribus id aut perspiciatis blanditiis voluptatem. Dolor dolor qui voluptatum dicta. Quam repellat sint rem exercitationem.\n\nQuod voluptate quibusdam ut quia animi. Debitis voluptas non cum magnam enim. Cumque vel repellat sunt nihil quibusdam quas laboriosam. Placeat ut id eligendi ut autem tempora. Beatae labore cupiditate excepturi.\n\nEos modi ut nihil sed modi eum omnis. Perspiciatis non est assumenda dolores. Ab sint qui consequuntur et omnis laudantium corporis. Rem voluptatum numquam quisquam commodi.', 'Aspernatur ad excepturi unde ut. Dolor ipsum temporibus ullam quia. Hic molestias laboriosam perspiciatis voluptatum repellendus molestiae.\n\nOmnis sed eveniet veritatis nulla libero autem et aut. Dolore molestias quasi natus officia inventore dicta voluptatem quibusdam. Et quam laborum aspernatur placeat at sunt perspiciatis. Consequuntur quis ea enim odio. Laboriosam exercitationem saepe deleniti nostrum harum omnis.\n\nMaxime ut facere qui asperiores impedit maxime sit. Architecto labore illum voluptatibus distinctio asperiores alias provident. Ullam autem consectetur repellendus et dignissimos.', NULL, NULL, 120, 0, 100, NULL, NULL, 0, 100, NULL, NULL, NULL, NULL, 'product/four.jpg', NULL, NULL, NULL, NULL, NULL, '2024-07-25 20:15:11', '2024-07-25 14:15:11', '2024-07-25 14:15:11', NULL, 'Comic-Con International', 'Wintheiser, Feil and Kshlerin', '2024-08-04 14:15:11', '2024-08-06 14:15:11', '2024-08-02 14:15:11', 'East Shannyburgh'),
	(115, NULL, NULL, 'Glastonbury Festival Ticket', 'glastonbury-festival-66a2b24fd0f12', NULL, 1, 1, 'Nihil optio deserunt ratione necessitatibus ullam minima dolore. Quidem odit et rerum similique et. Vel vero debitis minima minima. Id in veritatis incidunt possimus commodi dolor saepe est.\n\nMolestias minus ut ea reiciendis. Rerum quas facere voluptas repellendus et. Non molestiae excepturi velit maiores. Recusandae libero suscipit vel tenetur dolor sed.\n\nVitae molestiae recusandae culpa nemo consectetur minus incidunt ab. Et in dicta fugit voluptas corporis et deleniti et. Ut quia perferendis quia blanditiis quia. Ullam voluptatem molestias aliquam minus molestias animi officiis modi. Unde nihil dicta accusamus distinctio reprehenderit facere.', 'Ad qui enim repudiandae iste sapiente quis dolores. Iusto quas et et et. Maiores occaecati est beatae quisquam nihil explicabo minus. Sed eos voluptatum omnis aliquid.\n\nReiciendis minus et ipsam provident temporibus quia. Rerum rem nostrum quo tempora asperiores quae repellendus. Ea quia aut vero placeat dolor facere porro. Iure dolore labore quia adipisci et est.\n\nSequi id omnis voluptatum unde eveniet. Mollitia architecto sint enim nesciunt rerum dolores. Consequatur adipisci ratione saepe qui. Velit veniam voluptatibus voluptatem vitae quis quos.', NULL, NULL, 120, 0, 100, NULL, NULL, 0, 100, NULL, NULL, NULL, NULL, 'product/one.jpg', NULL, NULL, NULL, NULL, NULL, '2024-07-25 20:15:11', '2024-07-25 14:15:11', '2024-07-25 14:15:11', NULL, 'Glastonbury Festival', 'Sporer-Renner', '2024-08-04 14:15:11', '2024-08-06 14:15:11', '2024-08-02 14:15:11', 'New Lucio'),
	(116, NULL, NULL, 'DEF CON Ticket', 'def-con-66a2b24fd107d', NULL, 1, 1, 'Nostrum eaque omnis animi delectus porro dolorum cupiditate. Voluptas dignissimos dolor debitis accusamus recusandae tempore eum. Eius accusamus dolorem molestiae expedita.\n\nAssumenda nisi minima ut mollitia earum tempore velit. Occaecati qui eos quod quia.\n\nAut itaque est deleniti esse fugiat sequi eos. Voluptas et nam rerum et vero culpa necessitatibus.', 'Blanditiis delectus blanditiis doloremque. Est sed et est quia. Voluptates nemo fugit iusto et facere unde dolor.\n\nInventore quasi voluptate eos sed similique qui. Praesentium iusto amet molestiae qui ex necessitatibus qui incidunt. Quisquam autem vel non repellendus aut odit necessitatibus.\n\nDolorum quo sit similique quis ea eum consectetur magni. Dolores vero laborum ad velit optio iusto ut. Asperiores quia sit quia. Quia harum minus neque mollitia.', NULL, NULL, 120, 0, 100, NULL, NULL, 0, 100, NULL, NULL, NULL, NULL, 'product/three.jpg', NULL, NULL, NULL, NULL, NULL, '2024-07-25 20:15:11', '2024-07-25 14:15:11', '2024-07-25 14:15:11', NULL, 'DEF CON', 'Fritsch, Hill and Hamill', '2024-08-04 14:15:11', '2024-08-06 14:15:11', '2024-08-02 14:15:11', 'South Clementinestad');

-- Dumping structure for table ticket.ratings
CREATE TABLE IF NOT EXISTS `ratings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `shop_id` bigint unsigned NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `review` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ratings_product_id_foreign` (`product_id`),
  KEY `ratings_user_id_foreign` (`user_id`),
  KEY `ratings_shop_id_foreign` (`shop_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.ratings: ~1 rows (approximately)
INSERT INTO `ratings` (`id`, `product_id`, `user_id`, `shop_id`, `status`, `name`, `email`, `rating`, `review`, `created_at`, `updated_at`) VALUES
	(1, 63, 2, 11, 1, 'Lane Mccall', 'fatikyromi@mailinator.com', '3', 'Et libero qui adipis', '2023-09-26 11:11:00', '2023-09-26 11:11:00');

-- Dumping structure for table ticket.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.roles: ~3 rows (approximately)
INSERT INTO `roles` (`id`, `name`, `display_name`, `created_at`, `updated_at`) VALUES
	(1, 'admin', 'Administrator', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
	(2, 'user', 'Customers', '2023-09-08 23:30:27', '2023-10-05 05:40:09'),
	(3, 'vendor', 'Hotel Owner', '2023-09-08 23:30:27', '2023-10-05 05:40:36');

-- Dumping structure for table ticket.settings
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int NOT NULL DEFAULT '1',
  `group` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.settings: ~24 rows (approximately)
INSERT INTO `settings` (`id`, `key`, `display_name`, `value`, `details`, `type`, `order`, `group`) VALUES
	(1, 'site.title', 'Site Title', 'Event Ticket', '', 'text', 1, 'Site'),
	(2, 'site.description', 'Site Description', 'Join Eventify and take your events to the next level!', '', 'text', 2, 'Site'),
	(3, 'site.logo', 'Site Logo', 'settings\\July2024\\6KMXJOx1JfKYJZ86tjHp.jpg', '', 'image', 3, 'Site'),
	(4, 'site.google_analytics_tracking_id', 'Google Analytics Tracking ID', NULL, '', 'text', 4, 'Site'),
	(5, 'admin.bg_image', 'Admin Background Image', 'settings/September2023/Wx2g4pOGWbQH5KHuKOJt.jpg', '', 'image', 5, 'Admin'),
	(6, 'admin.title', 'Admin Title', 'Event Tickets', '', 'text', 1, 'Admin'),
	(7, 'admin.description', 'Admin Description', 'Join Eventify and take your events to the next level!', '', 'text', 2, 'Admin'),
	(8, 'admin.loader', 'Admin Loader', 'settings/September2023/4VG5nar1uT57uaSWWpi9.png', '', 'image', 3, 'Admin'),
	(9, 'admin.icon_image', 'Admin Icon Image', 'settings/September2023/XF7K5ZoiyJ6wwSWrQ7VP.png', '', 'image', 4, 'Admin'),
	(10, 'admin.google_analytics_client_id', 'Google Analytics Client ID (used for admin dashboard)', NULL, '', 'text', 1, 'Admin'),
	(12, 'site.newslletter_logo', 'newslletter_logo', '', NULL, 'image', 6, 'Site'),
	(22, 'site.icon', 'Icon', 'settings\\July2024\\TVsN1ll2MB9CUUWxmsPt.jpg', NULL, 'image', 15, 'Site'),
	(25, 'site.client_id', 'client ID', NULL, NULL, 'text', 18, 'Site'),
	(27, 'site.paypal_secret_id', 'Paypal Secret ID', NULL, NULL, 'text', 20, 'Site'),
	(28, 'social.fb_link', 'facebook', 'https://www.facebook.com/', NULL, 'text', 21, 'Social'),
	(30, 'social.inst_link', 'instagram', NULL, NULL, 'text', 23, 'Social'),
	(31, 'social.twiter_link', 'twiter', NULL, NULL, 'text', 24, 'Social'),
	(32, 'site.phone', 'phone', '70223322', NULL, 'text', 25, 'Site'),
	(33, 'site.email', 'email', NULL, NULL, 'text', 26, 'Site'),
	(35, 'site.logo_dark', 'Logo dark', 'settings\\July2024\\Jr4xzVKX3NYBRYfC16wR.jpg', NULL, 'image', 27, 'Site'),
	(37, 'site.video', 'Video Link', NULL, NULL, 'text', 28, 'Site'),
	(38, 'site.about', 'About', NULL, NULL, 'text_area', 29, 'Site'),
	(40, 'social.youtube', 'Youtube', NULL, NULL, 'text', 31, 'Social'),
	(41, 'social.pinterest', 'Pinterest', NULL, NULL, 'text', 32, 'Social');

-- Dumping structure for table ticket.shops
CREATE TABLE IF NOT EXISTS `shops` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `short_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `terms` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `company_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_registration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `shops_slug_unique` (`slug`),
  KEY `shops_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ticket.shops: ~8 rows (approximately)
INSERT INTO `shops` (`id`, `name`, `user_id`, `slug`, `email`, `phone`, `logo`, `banner`, `description`, `short_description`, `tags`, `terms`, `company_name`, `company_registration`, `city`, `state`, `post_code`, `country`, `status`, `created_at`, `updated_at`) VALUES
	(11, 'Hotel Griffen Spa og hotel', 9, 'pearl-payne-2', 'info@minglemo.com', '28599786', 'shops/October2023/ei2bnhohasfvPlO1EJfs.jpg', 'shop/dlZ8B5oS6j4MEcNU9cGBnLqAaHzn0halg1Y1vASB.jpg', '<p class="MsoNormal"><strong><span style="font-family: \'Segoe UI\',sans-serif; color: black; background: white;">Nyd En Eksklusiv Oplevelse p&aring; Bornholm for Kvinder</span></strong></p>\r\n<p class="MsoNormal"><strong><span style="font-family: \'Segoe UI\',sans-serif; color: black; background: white;">&nbsp;</span></strong></p>\r\n<p class="MsoNormal"><strong><em><span style="font-family: \'Segoe UI\',sans-serif; color: black; background: white; font-weight: normal;">Velkommen til en uforglemmelig oplevelse p&aring; det smukke Bornholm, skabt specielt til kvinder. Tag med os p&aring; en unik rejse til Griffen Spahotel, der ligger p&aring; den idylliske Ndr. Kystvej 34 i R&oslash;nne.</span></em></strong></p>\r\n<p class="MsoNormal"><strong><span style="font-family: \'Segoe UI\',sans-serif; color: black; background: white;">&nbsp;</span></strong></p>\r\n<p class="MsoNormal"><strong><span style="font-family: \'Segoe UI\',sans-serif; color: black; background: white; font-weight: normal;">Griffen Spahotel er mere end bare et sted at overnatte. Det er et moderne nordisk kunstv&aelig;rk designet af den bornholmske designer Pernille B&uuml;low. Her venter dig smukt indrettede v&aelig;relser, hvor vores tilbud er g&aelig;ldende for de v&aelig;relser som har havudsigt.. Dobbeltv&aelig;relserne ligger i stueplan, 1. eller 2. sal, og der er elevator tilg&aelig;ngelig til 1. og 2. sal.</span></strong></p>\r\n<p class="MsoNormal"><strong><span style="font-family: \'Segoe UI\',sans-serif; color: black; background: white;">&nbsp;</span></strong></p>\r\n<p class="MsoNormal"><strong><span style="font-family: \'Segoe UI\',sans-serif; color: black; background: white; font-weight: normal;">Griffen Spahotel er det perfekte udgangspunkt for din Bornholm-ferie, og du beh&oslash;ver ikke engang at medbringe din egen bil. Vi tilbyder gratis cykler i receptionen, og Bornholms omfattende netv&aelig;rk af cykelstier begynder kun 50 meter fra hotellet. P&aring; f&aring; minutter kan du udforske de hyggelige skovstier eller tage en tur til r&oslash;geriet i Hasle og smage de l&aelig;kre r&oslash;gede sild.</span></strong></p>\r\n<p class="MsoNormal"><strong><span style="font-family: \'Segoe UI\',sans-serif; color: black; background: white;">&nbsp;</span></strong></p>\r\n<p class="MsoNormal"><strong><span style="font-family: \'Segoe UI\',sans-serif; color: black; background: white;">Hvad Inkluderer Dette Eksklusive Tilbud?</span></strong></p>\r\n<p class="MsoNormal"><strong><span style="font-family: \'Segoe UI\',sans-serif; color: black; background: white;">&nbsp;</span></strong></p>\r\n<p class="MsoNormal"><strong><span style="font-family: \'Segoe UI\',sans-serif; color: black; background: white; font-weight: normal;">Vi har sikret en eksklusiv aftale med Griffen Spahotel, der g&oslash;r, at visse datoer udelukkende er for kvinder, s&aring; du kan nyde en afslappende spaoplevelse i ren komfort og ro. Som en ekstra bonus kan du ogs&aring; v&aelig;lge mellem de f&oslash;lgende l&aelig;kkerier fra vores &aacute; la carte menu:</span></strong></p>\r\n<p class="MsoNormal"><strong><span style="font-family: \'Segoe UI\',sans-serif; color: black; background: white; font-weight: normal;">&nbsp;</span></strong></p>\r\n<p class="MsoNormal"><strong><span style="font-family: \'Segoe UI\',sans-serif; color: black; background: white; font-weight: normal;">Halal Kylling: Vi serverer halal kylling, tilberedt separat fra andre k&oslash;dretter, for at im&oslash;dekomme dine pr&aelig;ferencer.</span></strong></p>\r\n<p class="MsoNormal"><strong><span style="font-family: \'Segoe UI\',sans-serif; color: black; background: white; font-weight: normal;">Bornholmsk Fisk: Nyd Bornholms yndlingsservering - friskfanget fisk, tilberedt med k&aelig;rlighed og tradition.</span></strong></p>\r\n<p class="MsoNormal"><strong><span style="font-family: \'Segoe UI\',sans-serif; color: black; background: white;">&nbsp;</span></strong></p>\r\n<p class="MsoNormal"><strong><span style="font-family: \'Segoe UI\',sans-serif; color: black; background: white;">Detaljer om Tilbuddet:</span></strong></p>\r\n<p class="MsoNormal"><strong><span style="font-family: \'Segoe UI\',sans-serif; color: black; background: white;">&nbsp;</span></strong></p>\r\n<p class="MsoNormal"><strong><span style="font-family: \'Segoe UI\',sans-serif; color: black; background: white; font-weight: normal;">Dette eksklusive tilbud g&aelig;lder for 2 personer, der vil dele et dobbeltv&aelig;relse med en fortryllende havudsigt. Prisen inkluderer en l&aelig;kker morgenmad, adgang til spaomr&aring;det p&aring; udvalgte tidspunkter samt en sk&oslash;n 3-retters &aacute; la carte menu.</span></strong></p>\r\n<p class="MsoNormal"><strong><span style="font-family: \'Segoe UI\',sans-serif; color: black; background: white;">&nbsp;</span></strong></p>\r\n<p class="MsoNormal"><strong><span style="font-family: \'Segoe UI\',sans-serif; color: black; background: white; font-weight: normal;">Normalpris: 2.700 DKK</span></strong></p>\r\n<p class="MsoNormal"><strong><span style="font-family: \'Segoe UI\',sans-serif; color: black; background: white; font-weight: normal;">Din Pris: Kun 2.430 DKK</span></strong></p>\r\n<p class="MsoNormal"><strong><span style="font-family: \'Segoe UI\',sans-serif; color: black; background: white; font-weight: normal;">Du Spar: 10%</span></strong></p>\r\n<p class="MsoNormal"><strong><span style="font-family: \'Segoe UI\',sans-serif; color: black; background: white;">&nbsp;</span></strong></p>\r\n<p class="MsoNormal"><strong><span style="font-family: \'Segoe UI\',sans-serif; color: black; background: white; font-weight: normal;">Tag en pause fra hverdagens travlhed og fork&aelig;l dig selv med denne unikke oplevelse p&aring; Griffen Spahotel. Oplev Bornholm i al sin sk&oslash;nhed, og lad os s&oslash;rge for, at din rejse bliver uforglemmelig. Book din plads i dag, og gl&aelig;d dig til at skabe smukke minder p&aring; &oslash;en med Bornholms hjerte.</span></strong></p>', 'Griffen Spahotel er mere end bare et sted at overnatte. Det er et moderne nordisk kunstværk designet af den bornholmske designer Pernille Bülow. Her venter dig smukt indrettede værelser, hvor vores tilbud er gældende for de værelser som har havudsigt', NULL, '-Gældende kun på følgende datoer\r\n12-14 April 2024\r\n10-12 maj 2024\r\nSpaén lukkes af udelukkende til kvinder på bestemte tidsrum. 2 timer på følgende tidspunkter. fredag aften fra kl. 16-18. Lørdag fra 11-13 samt Søndag fra 8-10.', 'Griffen Spahotel', 'DK-22113322', 'Rønne', 'Rønne', '9900', 'Danmark', 1, '2023-09-10 23:39:00', '2023-10-23 19:50:40'),
	(14, 'Brønshøj Beauty', 35, 'Karma', 'sulligee786@gmail.com', '+4528599786', 'shop/HtCvyP2fC27Xe90Opd4ZxuEuTlYBSpeU79SSc3PG.png', NULL, '<p>This is a test for Karma by sultana. The shop is offering various beauty and parlour offers. They are located in Copenhagen and have two shops.&nbsp;</p>', 'This is a test for Karma by sultana. The shop is offering various beauty and parlour offers.', NULL, 'The voucher must be used within 1 month after the last sale date. A month is considered as 31 days.', 'Karma by Sultana Aps', 'DK-22113322', 'Brønshøj', 'Copenhagen', '1164', 'Denmark', 1, '2023-09-26 16:51:00', '2023-10-20 12:23:36'),
	(15, 'Restaurant Silo', 38, 'restaurant-silo', NULL, NULL, 'shop/10fGfAiC5vcJSML5T30S3R0ewVNAXG5NnFcTc7Gs.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'København', 'København', NULL, 'Danmark', 1, '2023-10-20 12:18:19', '2023-10-20 12:18:19'),
	(16, 'Micro Fue Turkey', 39, 'micro-fue-turkey', NULL, NULL, 'shop/NtMcwnp0cZVvsGP0Sb5DrfYwkc9n3dLRuhT2xHih.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kusadasi', 'Kusadasi', NULL, 'Tyrkiet', 1, '2023-10-20 12:20:58', '2023-10-20 12:20:58'),
	(17, 'Restaurant Høst', 40, 'restaurant-host', NULL, NULL, 'shop/UmdKpQcAUv2eAVlNOXDA0CCHNTXxmvZuQLUhPvkv.avif', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'København', 'Indre København', NULL, 'Danmark', 1, '2023-10-20 12:35:09', '2023-10-20 12:35:09'),
	(18, 'Rump ´N Rips', 41, 'rump-n-rips', NULL, NULL, 'shop/QZumEnyioSZjweWmpjvx1X4TrGyAQlTHwH3uzdf8.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Manchester', 'Manchester', NULL, 'UK', 1, '2023-10-20 12:37:17', '2023-10-20 12:37:17'),
	(19, 'Hotel Rafael on the left bank', 42, 'hotel-rafael-on-the-left-bank', NULL, NULL, 'shop/5sdiJIk1FZ30zFNkZCRvzefD1V4EbBwuZyGlxKaI.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'London', 'London', NULL, 'UK', 1, '2023-10-20 12:47:35', '2023-10-20 12:47:35'),
	(20, 'Marias', 71, 'marias', NULL, NULL, 'shop/rECbEhxUN7d0LUvEFhZZd29XjmrBQCKHJLeRxjqR.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'København', 'København', NULL, 'Danmark', 1, '2024-03-31 17:46:07', '2024-03-31 17:46:07');

-- Dumping structure for table ticket.shop_policies
CREATE TABLE IF NOT EXISTS `shop_policies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` bigint unsigned NOT NULL,
  `delivery` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_option` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `return_exchange` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cancellation` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shop_policies_shop_id_foreign` (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.shop_policies: ~0 rows (approximately)

-- Dumping structure for table ticket.shop_user
CREATE TABLE IF NOT EXISTS `shop_user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shop_user_shop_id_foreign` (`shop_id`),
  KEY `shop_user_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.shop_user: ~0 rows (approximately)

-- Dumping structure for table ticket.sliders
CREATE TABLE IF NOT EXISTS `sliders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.sliders: ~6 rows (approximately)
INSERT INTO `sliders` (`id`, `image`, `created_at`, `updated_at`, `title`, `sub_title`, `link`) VALUES
	(1, 'sliders/September2023/xhXz7O2plwp6yJ3V1pd4.jpg', '2023-09-14 00:42:00', '2023-09-26 16:38:19', NULL, NULL, NULL),
	(2, 'sliders/September2023/Vy5l3Lp97jfOMeYmuJRY.jpg', '2023-09-14 00:49:00', '2023-09-26 16:37:42', NULL, NULL, NULL),
	(3, 'sliders/September2023/UXaJ084vcQLG3LsOCnAq.jpg', '2023-09-25 23:40:00', '2023-09-26 16:37:26', 'test', 'test', 'http://hotel.test/product/test'),
	(5, 'sliders/October2023/qNF97Z8DoSvgfwHfUCCG.jpg', '2023-10-23 19:51:00', '2023-10-24 18:26:31', 'Del dine oplevelser med andre.', 'Skab rammerne med dine nærmeste', NULL),
	(6, 'sliders/October2023/Fgr6NJHFSEweTzuiJCIs.jpg', '2023-10-23 19:54:00', '2023-10-24 17:58:50', 'Spis, rejs og lev', 'Få kulinariske halal oplevelser.', NULL),
	(7, 'sliders/October2023/4aPeWipG8o125GRcTUdc.jpg', '2023-10-23 20:06:00', '2023-10-23 20:09:08', 'At rejse er at leve.', 'Oplev verdenen med os!', NULL);

-- Dumping structure for table ticket.subscriptions
CREATE TABLE IF NOT EXISTS `subscriptions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_price` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subscriptions_stripe_id_unique` (`stripe_id`),
  KEY `subscriptions_user_id_stripe_status_index` (`user_id`,`stripe_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.subscriptions: ~0 rows (approximately)

-- Dumping structure for table ticket.subscription_items
CREATE TABLE IF NOT EXISTS `subscription_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `subscription_id` bigint unsigned NOT NULL,
  `stripe_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_product` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_price` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subscription_items_subscription_id_stripe_price_unique` (`subscription_id`,`stripe_price`),
  UNIQUE KEY `subscription_items_stripe_id_unique` (`stripe_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.subscription_items: ~0 rows (approximately)

-- Dumping structure for table ticket.tickets
CREATE TABLE IF NOT EXISTS `tickets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint DEFAULT NULL,
  `shop_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `subject` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `massage` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `action` tinyint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tickets_shop_id_foreign` (`shop_id`),
  KEY `tickets_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.tickets: ~2 rows (approximately)
INSERT INTO `tickets` (`id`, `parent_id`, `shop_id`, `user_id`, `subject`, `massage`, `image`, `status`, `action`, `created_at`, `updated_at`) VALUES
	(1, NULL, 11, NULL, 'Nesciunt omnis cons', 'Et lorem quam qui un', NULL, 0, NULL, '2023-09-11 23:53:59', '2023-09-11 23:56:48'),
	(2, NULL, 20, NULL, 'problemer ned tkfjf', 'sldfjsdfjdslæf', NULL, 0, NULL, '2024-03-31 18:27:51', '2024-03-31 18:27:51');

-- Dumping structure for table ticket.translations
CREATE TABLE IF NOT EXISTS `translations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `table_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `column_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `foreign_key` int unsigned NOT NULL,
  `locale` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `translations_table_name_column_name_foreign_key_locale_unique` (`table_name`,`column_name`,`foreign_key`,`locale`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.translations: ~30 rows (approximately)
INSERT INTO `translations` (`id`, `table_name`, `column_name`, `foreign_key`, `locale`, `value`, `created_at`, `updated_at`) VALUES
	(1, 'data_types', 'display_name_singular', 5, 'pt', 'Post', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
	(2, 'data_types', 'display_name_singular', 6, 'pt', 'Página', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
	(3, 'data_types', 'display_name_singular', 1, 'pt', 'Utilizador', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
	(4, 'data_types', 'display_name_singular', 4, 'pt', 'Categoria', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
	(5, 'data_types', 'display_name_singular', 2, 'pt', 'Menu', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
	(6, 'data_types', 'display_name_singular', 3, 'pt', 'Função', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
	(7, 'data_types', 'display_name_plural', 5, 'pt', 'Posts', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
	(8, 'data_types', 'display_name_plural', 6, 'pt', 'Páginas', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
	(9, 'data_types', 'display_name_plural', 1, 'pt', 'Utilizadores', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
	(10, 'data_types', 'display_name_plural', 4, 'pt', 'Categorias', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
	(11, 'data_types', 'display_name_plural', 2, 'pt', 'Menus', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
	(12, 'data_types', 'display_name_plural', 3, 'pt', 'Funções', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
	(13, 'categories', 'slug', 1, 'pt', 'categoria-1', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
	(14, 'categories', 'name', 1, 'pt', 'Categoria 1', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
	(15, 'categories', 'slug', 2, 'pt', 'categoria-2', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
	(16, 'categories', 'name', 2, 'pt', 'Categoria 2', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
	(17, 'pages', 'title', 1, 'pt', 'Olá Mundo', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
	(18, 'pages', 'slug', 1, 'pt', 'ola-mundo', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
	(19, 'pages', 'body', 1, 'pt', '<p>Olá Mundo. Scallywag grog swab Cat o\'nine tails scuttle rigging hardtack cable nipper Yellow Jack. Handsomely spirits knave lad killick landlubber or just lubber deadlights chantey pinnace crack Jennys tea cup. Provost long clothes black spot Yellow Jack bilged on her anchor league lateen sail case shot lee tackle.</p>\r\n<p>Ballast spirits fluke topmast me quarterdeck schooner landlubber or just lubber gabion belaying pin. Pinnace stern galleon starboard warp carouser to go on account dance the hempen jig jolly boat measured fer yer chains. Man-of-war fire in the hole nipperkin handsomely doubloon barkadeer Brethren of the Coast gibbet driver squiffy.</p>', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
	(20, 'menu_items', 'title', 1, 'pt', 'Painel de Controle', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
	(21, 'menu_items', 'title', 2, 'pt', 'Media', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
	(22, 'menu_items', 'title', 12, 'pt', 'Publicações', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
	(23, 'menu_items', 'title', 3, 'pt', 'Utilizadores', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
	(24, 'menu_items', 'title', 11, 'pt', 'Categorias', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
	(25, 'menu_items', 'title', 13, 'pt', 'Páginas', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
	(26, 'menu_items', 'title', 4, 'pt', 'Funções', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
	(27, 'menu_items', 'title', 5, 'pt', 'Ferramentas', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
	(28, 'menu_items', 'title', 6, 'pt', 'Menus', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
	(29, 'menu_items', 'title', 7, 'pt', 'Base de dados', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
	(30, 'menu_items', 'title', 10, 'pt', 'Configurações', '2023-09-08 23:30:27', '2023-09-08 23:30:27');

-- Dumping structure for table ticket.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint unsigned DEFAULT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `l_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'users/default.png',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `settings` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stripe_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pm_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pm_last_four` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `paid_at` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_id_foreign` (`role_id`),
  KEY `users_stripe_id_index` (`stripe_id`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.users: ~26 rows (approximately)
INSERT INTO `users` (`id`, `role_id`, `name`, `l_name`, `email`, `avatar`, `email_verified_at`, `password`, `remember_token`, `settings`, `created_at`, `updated_at`, `stripe_id`, `pm_type`, `pm_last_four`, `trial_ends_at`, `paid_at`) VALUES
	(2, 1, 'Sayed', NULL, 'reovilsayed@gmail.com', 'users/c0HSTPAG3AUQrO5L4vMkcjTj5OyqaAFBp0feEys4.png', '2023-10-05 05:44:45', '$2y$10$S.4Hdu6VwApWiG5CybGyXuOAfKSQyRARiGS9tK37LSeNGgRxvcN.u', 'RcSIfkVs87XnHkxtMazRFbuyvwdil0mcXbYagWlKNee7DfY5sXeYOkHUfdoj', '{"locale":"en"}', '2023-09-08 23:30:27', '2024-04-16 09:26:19', NULL, NULL, NULL, NULL, NULL),
	(8, 2, 'Allistair Davidson', 'Wynter Pollard', 'beqovuz@mailinator.com', 'users/default.png', NULL, '$2y$10$h7LalA3v6DnuqtysbnOiweTI659JwFvY.ZT.8bibnWsQlr.DC/ypO', NULL, NULL, '2023-09-10 00:25:08', '2023-09-10 00:25:08', NULL, NULL, NULL, NULL, NULL),
	(9, 3, 'Hotel Griffen Spa og hotel', 'Keith Wilson', 'lilikasi@mailinator.com', 'users/default.png', '2023-09-10 00:37:45', '$2y$10$1AYSmgO6YQZNtH6oLT2nveVLws3eLSM4Yz64ecf.9JYNTKFq7bDvO', 'plLbOfjYSOVK0e93cAc25g9cUTnLiWqPglV43JUDxVPAcIJeATVaAaEyFt1p', '{"locale":"en"}', '2023-09-10 00:25:34', '2023-10-20 12:22:16', NULL, NULL, NULL, NULL, NULL),
	(16, 3, 'Brynne Holland', 'Willow Dejesus', 'asalaminshikder787@gmail.com', 'users/default.png', NULL, '$2y$10$Bs6aERrhm8rhW0O76OKop.DfbrjPTHfH0//HIIhMJWuh6YWMzqEki', NULL, NULL, '2023-09-23 13:26:24', '2023-09-23 13:26:24', NULL, NULL, NULL, NULL, NULL),
	(35, 3, 'Brønshøj Beauty', 'Ulysses Jordan', 'xihed@mailinator.com', 'users/default.png', NULL, '$2y$10$2i4ykwC4azKOaINDgqOd1ujZWECoDKb3l9wBzkJxiZv66m9EUe0mC', NULL, '{"locale":"en"}', '2023-09-26 08:10:54', '2023-10-20 12:23:36', NULL, NULL, NULL, NULL, NULL),
	(36, 3, 'sayed khan', 'sayed khan', 'reovilsayedsd@gmail.com', 'users/default.png', NULL, '$2y$10$7mOcHx9bex2Lt9Y5J7GTJOIha5eDLFWpYlPYKoK/Lof4k.a3/enxu', NULL, NULL, '2023-10-04 08:38:34', '2023-10-04 08:38:34', NULL, NULL, NULL, NULL, NULL),
	(37, 3, 'sayed khan', 'sayed khan', 'reovilsayed01@gmail.com', 'users/default.png', '2023-10-05 05:44:58', '$2y$10$d6oPKKebVtvqt/m/bScIKebUJdT9D18iRCjoweq1Yepz2ajMToEHq', 'oBifRVbL1TnmzFAoqrcv', NULL, '2023-10-05 05:44:26', '2023-10-05 05:44:58', NULL, NULL, NULL, NULL, NULL),
	(38, 1, 'Sulli', 'Gee', 'sulligee786@gmail.com', 'users/default.png', NULL, '$2y$10$zAg6x.OOUbCYRjYQunCPV.aeq.EIF6En5g.2ZPu7UPglMGM/XEO36', '9TsPYwy25bx0vKWSY0aBqem9toAaHghrDufXqrOQ5FVTCp2dLZxiuyzkXMou', '{"locale":"en"}', '2023-10-20 12:18:19', '2024-04-30 15:28:05', NULL, NULL, NULL, NULL, NULL),
	(39, 3, 'Micro Fue Turkey', NULL, 'sulligees@gmail.com', 'users/default.png', NULL, '$2y$10$JURKY3.QCdiVcBoWcU3t0uhiT1ShrQauRVIdMoDun/XgsC5lXIIJa', NULL, NULL, '2023-10-20 12:20:58', '2023-10-20 12:20:58', NULL, NULL, NULL, NULL, NULL),
	(41, 3, 'Rump `N Rips', NULL, 'info@eu-shop.co.uk', 'users/default.png', NULL, '$2y$10$9J2I7G3ij7aTYTp/Vlk.HOQ5NSz6135l6THYgQrRCuun.6qC9zpMa', NULL, NULL, '2023-10-20 12:37:17', '2023-10-20 12:37:17', NULL, NULL, NULL, NULL, NULL),
	(42, 3, 'Hotel Rafael on the left bank', NULL, 'sullis@gmail.com', 'users/default.png', NULL, '$2y$10$kHZmgyUY7VmLSQyxThbHruVSWxqW4ALRiRMQUbovUOXSZBfihCwJ6', NULL, NULL, '2023-10-20 12:47:35', '2023-10-20 12:47:35', NULL, NULL, NULL, NULL, NULL),
	(43, 2, 'Sonia Simon', 'Zeus Rivers', 'bemesy@mailinator.com', 'users/default.png', NULL, '$2y$10$UFNAJHyQjOyEyh14X4VRBefGLaNrImPGY0hrbAE0bHCsynQkDaZ.2', NULL, NULL, '2023-10-22 13:42:27', '2023-10-22 13:42:27', NULL, NULL, NULL, NULL, NULL),
	(44, 2, 'Anders', 'Vebø', 'anvendet@gmail.com', 'users/default.png', NULL, '$2y$10$5EtVpk0TfpHL.h8I9BeIPOddYs72Lq7IIlyRehRv6A3yJYQKlt6t6', NULL, NULL, '2023-11-03 15:24:34', '2023-11-03 15:24:34', NULL, NULL, NULL, NULL, NULL),
	(70, 1, 'Iman Rasmussen', NULL, 'theresebroch@gmail.com', 'users/default.png', NULL, '$2y$10$vxHKl8sOv0mNGotj40GuCeON1RU2rP4pEkKZ62kQgtpaX9wi9nJkK', 'fKd13t3i37wnpjCKS20mp3ZZKHDoIaoxRAfAB91lOPWxlQLRvL90LbZqVHwB', '{"locale":"en"}', '2024-03-31 17:42:05', '2024-03-31 17:42:05', NULL, NULL, NULL, NULL, NULL),
	(71, 3, 'Marias', NULL, 'kaffekilden41@gmail.com', 'users/default.png', NULL, '$2y$10$iu8Ya5XJGVlkJ13d9h8M2OGtg.L/fSIJQRDnGY2zTpg33C4uYUn3C', NULL, '{"locale":"en"}', '2024-03-31 17:46:07', '2024-07-15 18:51:56', NULL, NULL, NULL, NULL, NULL),
	(72, 2, NULL, NULL, 'qyhud@mailinator.com', 'users/default.png', NULL, '$2y$10$RmUpyM3tGzUJa1CYaNLQ.uZ9lkQpeDAMqr5xh9m8F/CWpn2B9IjGe', NULL, NULL, '2024-07-25 22:42:55', '2024-07-25 22:42:55', NULL, NULL, NULL, NULL, NULL),
	(73, 2, NULL, NULL, 'jobyvan@mailinator.com', 'users/default.png', NULL, '$2y$10$6fxCljMoM6atLPrDBibRee5e9HIzJ3YKCo2nE8Y0JS4GdonM6Wnvy', NULL, NULL, '2024-07-25 22:52:36', '2024-07-25 22:52:36', NULL, NULL, NULL, NULL, NULL),
	(74, 2, NULL, NULL, 'mypykeli@mailinator.com', 'users/default.png', NULL, '$2y$10$JOp1xBTSCITGbKgar.991.Xl1C/kRenBpm0m1rnkaxb/Z/RBTODYG', NULL, NULL, '2024-07-25 22:59:16', '2024-07-25 22:59:16', NULL, NULL, NULL, NULL, NULL),
	(75, 2, NULL, NULL, 'pevaporu@mailinator.com', 'users/default.png', NULL, '$2y$10$rZ8lrWNm1h3/0/mGPwyYUu3/E2Ek7dKt4s66hBftLyi036KkYL40u', NULL, NULL, '2024-07-25 23:07:00', '2024-07-25 23:07:00', NULL, NULL, NULL, NULL, NULL),
	(76, 2, NULL, NULL, 'vyzycijixy@mailinator.com', 'users/default.png', NULL, '$2y$10$Ca8y4SPccbEH7RwMpOJqiOIsCi8hJ1g0DTvzblQJDiOFBvk5vN1Si', NULL, NULL, '2024-07-25 23:08:52', '2024-07-25 23:08:52', NULL, NULL, NULL, NULL, NULL),
	(77, 2, NULL, NULL, 'sofajefyli@mailinator.com', 'users/default.png', NULL, '$2y$10$.fsyQNM9iipvR7DL.adlXuh4A5FSYiiQC9.SEmr6fafOCa/ZGkRni', NULL, NULL, '2024-07-25 23:15:41', '2024-07-25 23:15:41', NULL, NULL, NULL, NULL, NULL),
	(78, 2, 'Tashya Hurst', 'Ali Ortega', 'sawudec@mailinator.com', 'users/default.png', NULL, '$2y$10$TPbWO6f7RcqtnRArfzZCHeCvBaExxAcvNEPlYsTixbAMIYDITxx9q', NULL, NULL, '2024-07-25 23:17:11', '2024-07-25 23:17:11', NULL, NULL, NULL, NULL, NULL),
	(79, 2, 'Stuart Madden', 'Yeo Todd', 'mywetuku@mailinator.com', 'users/LV66NLRGjn1Wf4VTcAVpuPKtjA1OqfEa57qxWso7.jpg', NULL, '$2y$10$A6ztk6McS9ck7TSdmO4nTebUghyOtmqKBSRlx45Hx5JLfQHD2S8Yy', NULL, NULL, '2024-07-25 23:22:07', '2024-07-25 23:22:45', NULL, NULL, NULL, NULL, NULL),
	(80, 2, 'Keiko Hayes', 'Darrel Garza', 'kosy@mailinator.com', 'users/default.png', NULL, '$2y$10$B.EuK5ykAf0CDRaZBBgWt.2bykKzeojVYzM1lFVJre5nSIeaeQs1u', NULL, NULL, '2024-07-26 06:44:10', '2024-07-26 06:44:10', NULL, NULL, NULL, NULL, NULL),
	(81, 2, 'Chancellor Fry', 'Jillian Sweeney', 'xewaxomy@mailinator.com', 'users/default.png', NULL, '$2y$10$ao.D7xGuIUZEnDYZNBJTR.V3KG8u6pMt5EDb/DrMzZkTgpjpX7vuK', NULL, NULL, '2024-07-26 14:08:16', '2024-07-26 14:08:16', NULL, NULL, NULL, NULL, NULL),
	(82, 2, 'Ayanna Mathews', 'Mechelle Phillips', 'sycisy@mailinator.com', 'users/default.png', NULL, '$2y$10$ybDhABinaQl3KaaX/FdoNeg3I9/Fij9qqU9DgCVuN3r5vUc/Jr.zW', NULL, NULL, '2024-07-26 22:16:21', '2024-07-26 22:16:21', NULL, NULL, NULL, NULL, NULL);

-- Dumping structure for table ticket.user_roles
CREATE TABLE IF NOT EXISTS `user_roles` (
  `user_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `user_roles_user_id_index` (`user_id`),
  KEY `user_roles_role_id_index` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.user_roles: ~1 rows (approximately)
INSERT INTO `user_roles` (`user_id`, `role_id`) VALUES
	(70, 1);

-- Dumping structure for table ticket.verifications
CREATE TABLE IF NOT EXISTS `verifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `phone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `tax_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `govt_id_front` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `govt_id_back` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_ac` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paypal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `verifications_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ticket.verifications: ~2 rows (approximately)
INSERT INTO `verifications` (`id`, `user_id`, `phone`, `dob`, `tax_no`, `card_no`, `govt_id_front`, `govt_id_back`, `bank_ac`, `paypal`, `bank_name`, `created_at`, `updated_at`) VALUES
	(8, 9, NULL, '1978-05-04 18:00:00', 'Labore rerum reprehe', NULL, 'verifications/muvbkbpLh7z5NiFGbpLU3fIw9BR4jdooi5FLYXnW.png', 'verifications/N9dbYwivFuquM3pvxsNDRuTYVbiL9OWllErjDJ58.png', NULL, 'tamim@gmail.com', NULL, '2023-09-10 05:59:04', '2023-09-11 00:51:26'),
	(10, 37, NULL, '2003-05-25 04:00:00', '01926184022', NULL, 'verifications/IT7CU1MAv7DxdRAY9ntmN2gmOPz23ibnssWx2Xq6.png', 'verifications/oq4kGBiUwuDrroI5MlsXLzPbLlXng07KWNjrm4BI.png', NULL, NULL, NULL, '2023-10-05 05:48:53', '2023-10-05 05:48:53');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
