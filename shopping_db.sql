-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2024 at 06:32 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shopping_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `price` decimal(20,0) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `weight` decimal(10,0) DEFAULT NULL,
  `mweight` varchar(10) DEFAULT NULL,
  `discount` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discount`
--

CREATE TABLE `discount` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `price` decimal(20,0) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `weight` decimal(10,0) DEFAULT NULL,
  `mweight` varchar(10) DEFAULT NULL,
  `discount` decimal(10,0) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grns`
--

CREATE TABLE `grns` (
  `grn_number` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `grn_date` date NOT NULL,
  `gross_amount` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) DEFAULT 0.00,
  `net_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grns`
--

INSERT INTO `grns` (`grn_number`, `supplier_id`, `grn_date`, `gross_amount`, `discount`, `net_total`) VALUES
(2, 2, '2024-06-13', 1500.00, 0.00, 1500.00),
(3, 2, '2024-06-11', 1500.00, 0.00, 1500.00),
(12, 1, '2024-06-11', 13750.00, 0.00, 13750.00),
(32, 3, '2024-06-10', 3850.00, 0.00, 3850.00),
(45, 2, '2024-06-05', 2250.00, 0.00, 2250.00),
(77, 1, '2024-06-12', 157000.00, 0.00, 157000.00),
(90, 2, '2024-06-11', 285.00, 0.00, 285.00),
(98, 5, '2024-06-10', 3850.00, 0.00, 3850.00),
(111, 3, '2024-06-11', 1350.00, 0.00, 1350.00),
(112, 1, '2024-06-11', 13750.00, 0.00, 13750.00),
(145, 2, '2024-06-10', 86250.00, 100.00, 86150.00),
(1200, 2, '2024-06-11', 74250.00, 0.00, 74250.00);

-- --------------------------------------------------------

--
-- Table structure for table `grn_items`
--

CREATE TABLE `grn_items` (
  `item_id` int(11) NOT NULL,
  `grn_number` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `retail_price` decimal(10,2) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `total_cost` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) DEFAULT 0.00,
  `net_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grn_items`
--

INSERT INTO `grn_items` (`item_id`, `grn_number`, `product_id`, `product_name`, `quantity`, `retail_price`, `cost`, `total_cost`, `discount`, `net_total`) VALUES
(1, 1200, 1, 'Rice (Red)', 250, 230.00, 225.00, 56250.00, 0.00, 56250.00),
(2, 1200, 3, 'Dhal', 50, 385.00, 360.00, 18000.00, 0.00, 18000.00),
(4, 111, 2, 'Wheat Flour', 5, 285.00, 270.00, 1350.00, 0.00, 1350.00),
(5, 145, 3, 'Dhal', 230, 385.00, 375.00, 86250.00, 100.00, 86150.00),
(6, 12, 2, 'Wheat Flour', 50, 285.00, 275.00, 13750.00, 0.00, 13750.00),
(7, 112, 2, 'Wheat Flour', 50, 285.00, 275.00, 13750.00, 0.00, 13750.00),
(8, 45, 1, 'Rice (Red)', 10, 230.00, 225.00, 2250.00, 0.00, 2250.00),
(9, 3, 4, 'Basmati Rice', 3, 500.00, 500.00, 1500.00, 0.00, 1500.00),
(10, 77, 1, 'Rice (Red)', 100, 230.00, 230.00, 23000.00, 0.00, 23000.00),
(11, 77, 2, 'Wheat Flour', 200, 285.00, 285.00, 57000.00, 0.00, 57000.00),
(12, 77, 3, 'Dhal', 200, 385.00, 385.00, 77000.00, 0.00, 77000.00),
(13, 90, 2, 'Wheat Flour', 1, 285.00, 285.00, 285.00, 0.00, 285.00),
(14, 98, 2, 'Wheat Flour', 10, 385.00, 385.00, 3850.00, 0.00, 3850.00),
(15, 32, 3, 'Dhal', 10, 385.00, 385.00, 3850.00, 0.00, 3850.00);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `invoice_number` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `invoice_date` date NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) DEFAULT 0.00,
  `net_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`invoice_number`, `customer_id`, `invoice_date`, `total`, `discount`, `net_total`) VALUES
(12, 32, '2024-06-11', 1150.00, 0.00, 1150.00),
(22, 32, '2024-06-11', 93800.00, 0.00, 93800.00),
(33, 32, '2024-06-11', 570.00, 0.00, 570.00),
(34, 32, '2024-06-11', 11960.00, 0.00, 11960.00),
(56, 32, '2024-06-11', 3500.00, 0.00, 3500.00),
(67, 32, '2024-06-04', 1000.00, 0.00, 1000.00),
(76, 32, '2024-06-11', 570.00, 0.00, 570.00),
(98, 32, '2024-06-11', 45000.00, 0.00, 45000.00);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `item_id` int(11) NOT NULL,
  `invoice_number` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) DEFAULT 0.00,
  `net_total` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`item_id`, `invoice_number`, `product_id`, `product_name`, `unit_price`, `quantity`, `total`, `discount`, `net_total`, `total_price`) VALUES
(1, 34, 1, 'Rice (Red)', 230.00, 52, 11960.00, 0.00, 11960.00, 11960.00),
(2, 12, 1, 'Rice (Red)', 230.00, 5, 1150.00, 0.00, 1150.00, 1150.00),
(3, 67, 4, 'Basmati Rice', 500.00, 2, 1000.00, 0.00, 1000.00, 1000.00),
(4, 33, 2, 'Wheat Flour', 285.00, 2, 570.00, 0.00, 570.00, 570.00),
(5, 98, 23, 'Balsamic Vinegar', 900.00, 50, 45000.00, 0.00, 45000.00, 45000.00),
(6, 76, 2, 'Wheat Flour', 285.00, 2, 570.00, 0.00, 570.00, 570.00),
(7, 22, 51, 'Green Gram', 670.00, 140, 93800.00, 0.00, 93800.00, 93800.00),
(8, 56, 8, 'Black Tea', 350.00, 10, 3500.00, 0.00, 3500.00, 3500.00);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `method` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `total_products` int(11) DEFAULT NULL,
  `total_price` decimal(20,0) DEFAULT NULL,
  `placed_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `payment_status` varchar(100) NOT NULL DEFAULT 'pending',
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `price` decimal(20,0) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `weight` decimal(10,0) DEFAULT NULL,
  `mweight` varchar(10) DEFAULT NULL,
  `discount` decimal(10,0) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `details`, `price`, `image`, `weight`, `mweight`, `discount`, `supplier_id`) VALUES
(1, 'Rice (Red)', 'Grains', 'Rice', 230, 'images/001.jpg', 1, '.00Kg', 0, 1),
(2, 'Wheat Flour', 'Grains', 'Flour', 285, 'images/wf.jpg', 1, '.00Kg', 0, 2),
(3, 'Dhal', 'Grains', 'Dhal', 385, 'dhal.jpg', 1, '.00Kg', 0, 1),
(4, 'Basmati Rice', 'Grains', 'High-quality Basmati rice imported from India.', 500, 'basmati_rice.jpg', 1, '.00Kg', 0, 1),
(5, 'Red Lentils', 'Grains', 'Premium red lentils with excellent taste and texture.', 400, 'red_lentils.jpg', 1, '.00Kg', 0, 2),
(6, 'Cinnamon Powder', 'Condiment/Spices', 'Pure Ceylon cinnamon powder for culinary and medicinal use.', 300, 'cinnamon_powder.jpg', 1, '.00Kg', 0, 3),
(7, 'Coconut Oil', 'Oil/Vinegars', 'Cold-pressed virgin coconut oil extracted from fresh coconuts.', 600, 'coconut_oil.jpg', 1, '.00Kg', 0, 4),
(8, 'Black Tea', 'Other', 'Finest black tea leaves from the highlands of Sri Lanka.', 350, 'black_tea.jpg', 1, '.00Kg', 0, 5),
(9, 'Cashew Nuts', 'Other', 'Premium quality cashew nuts from local farms.', 700, 'cashew_nuts.jpg', 1, '.00Kg', 0, 6),
(10, 'Saffron Threads', 'Condiment/Spices', 'Exotic saffron threads sourced directly from growers.', 1000, 'saffron_threads.jpg', 1, '.00Kg', 0, 7),
(11, 'Palm Vinegar', 'Oil/Vinegars', 'Traditional palm vinegar made from natural palm sap.', 450, 'palm_vinegar.jpg', 1, '.00Kg', 0, 8),
(12, 'Jasmine Rice', 'Grains', 'Fragrant jasmine rice known for its aroma and flavor.', 550, 'jasmine_rice.jpg', 1, '.00Kg', 0, 9),
(13, 'Turmeric Powder', 'Condiment/Spices', 'Pure turmeric powder with vibrant color and potent flavor.', 320, 'turmeric_powder.jpg', 1, '.00Kg', 0, 10),
(14, 'Extra Virgin Olive Oil', 'Oil/Vinegars', 'Cold-pressed extra virgin olive oil imported from Italy.', 800, 'olive_oil.jpg', 1, '.00Kg', 0, 1),
(15, 'Mango Puree', 'Other', 'Sweet and tangy mango puree perfect for beverages and desserts.', 600, 'mango_puree.jpg', 1, '.00Kg', 0, 2),
(16, 'Coriander Seeds', 'Condiment/Spices', 'Aromatic coriander seeds for enhancing flavor in dishes.', 250, 'coriander_seeds.jpg', 1, '.00Kg', 0, 3),
(17, 'White Vinegar', 'Oil/Vinegars', 'Distilled white vinegar for pickling and household use.', 200, 'white_vinegar.jpg', 1, '.00Kg', 0, 4),
(18, 'Peanuts', 'Other', 'Crunchy and nutritious peanuts packed with protein and flavor.', 400, 'peanuts.jpg', 1, '.00Kg', 0, 5),
(19, 'Cardamom Pods', 'Condiment/Spices', 'Whole cardamom pods prized for their aromatic and medicinal properties.', 600, 'cardamom_pods.jpg', 1, '.00Kg', 0, 6),
(20, 'Apple Cider Vinegar', 'Oil/Vinegars', 'Raw and unfiltered apple cider vinegar with the mother.', 350, 'apple_cider_vinegar.jpg', 1, '.00Kg', 0, 7),
(21, 'Brown Sugar', 'Other', 'Natural brown sugar with a rich caramel flavor.', 300, 'brown_sugar.jpg', 1, '.00Kg', 0, 8),
(22, 'Fenugreek Seeds', 'Condiment/Spices', 'Nutty and aromatic fenugreek seeds used in Indian cuisine.', 280, 'fenugreek_seeds.jpg', 1, '.00Kg', 0, 9),
(23, 'Balsamic Vinegar', 'Oil/Vinegars', 'Aged balsamic vinegar with complex flavors and a sweet tang.', 900, 'balsamic_vinegar.jpg', 1, '.00Kg', 0, 10),
(24, 'Quinoa', 'Grains', 'Superfood quinoa known for its high protein and nutrient content.', 750, 'quinoa.jpg', 1, '.00Kg', 0, 1),
(25, 'Chili Powder', 'Condiment/Spices', 'Hot and spicy chili powder made from dried chili peppers.', 200, 'chili_powder.jpg', 1, '.00Kg', 0, 2),
(26, 'Rice Bran Oil', 'Oil/Vinegars', 'Heart-healthy rice bran oil with a high smoke point.', 650, 'rice_bran_oil.jpg', 1, '.00Kg', 0, 3),
(27, 'Sunflower Seeds', 'Other', 'Roasted sunflower seeds for snacking and baking.', 300, 'sunflower_seeds.jpg', 1, '.00Kg', 0, 4),
(28, 'Cumin Seeds', 'Condiment/Spices', 'Aromatic cumin seeds used as a spice in various cuisines.', 240, 'cumin_seeds.jpg', 1, '.00Kg', 0, 5),
(29, 'Sesame Oil', 'Oil/Vinegars', 'Toasted sesame oil with a rich nutty flavor and aroma.', 700, 'sesame_oil.jpg', 1, '.00Kg', 0, 6),
(30, 'Chia Seeds', 'Other', 'Nutrient-rich chia seeds packed with omega-3 fatty acids and fiber.', 500, 'chia_seeds.jpg', 1, '.00Kg', 0, 7),
(31, 'Paprika Powder', 'Condiment/Spices', 'Vibrant paprika powder adds color and flavor to dishes.', 180, 'paprika_powder.jpg', 1, '.00Kg', 0, 8),
(32, 'Rice Vinegar', 'Oil/Vinegars', 'Light and mild rice vinegar ideal for dressings and marinades.', 250, 'rice_vinegar.jpg', 1, '.00Kg', 0, 9),
(33, 'Steel-Cut Oats', 'Grains', 'Nutritious steel-cut oats for a healthy breakfast.', 400, 'steel_cut_oats.jpg', 1, '.00Kg', 0, 10),
(34, 'Garam Masala', 'Condiment/Spices', 'Classic Indian spice blend for adding warmth and depth to dishes.', 300, 'garam_masala.jpg', 1, '.00Kg', 0, 1),
(35, 'Avocado Oil', 'Oil/Vinegars', 'Rich and flavorful avocado oil for cooking and salad dressings.', 600, 'avocado_oil.jpg', 1, '.00Kg', 0, 2),
(36, 'Almond Flour', 'Other', 'Finely ground almond flour perfect for gluten-free baking.', 700, 'almond_flour.jpg', 1, '.00Kg', 0, 3),
(37, 'Mustard Seeds', 'Condiment/Spices', 'Whole mustard seeds used for pickling and flavoring dishes.', 250, 'mustard_seeds.jpg', 1, '.00Kg', 0, 4),
(38, 'Rice Noodles', 'Other', 'Versatile rice noodles for making stir-fries and noodle dishes.', 350, 'rice_noodles.jpg', 1, '.00Kg', 0, 5),
(39, 'Vanilla Extract', 'Other', 'Pure vanilla extract for adding sweet aroma to baked goods.', 800, 'vanilla_extract.jpg', 1, '.00Kg', 0, 6),
(40, 'Turmeric Root', 'Condiment/Spices', 'Fresh turmeric root known for its medicinal properties.', 200, 'turmeric_root.jpg', 1, '.00Kg', 0, 7),
(41, 'Soy Sauce', 'Other', 'Traditional soy sauce for seasoning and marinating.', 300, 'soy_sauce.jpg', 1, '.00Kg', 0, 8),
(42, 'Dried Thyme', 'Condiment/Spices', 'Aromatic dried thyme leaves for seasoning soups and stews.', 150, 'dried_thyme.jpg', 1, '.00Kg', 0, 9),
(43, 'Coconut Flour', 'Other', 'High-fiber coconut flour suitable for gluten-free baking.', 650, 'coconut_flour.jpg', 1, '.00Kg', 0, 10),
(44, 'Whole Wheat Flour', 'Grains', 'Nutrient-rich whole wheat flour for baking bread and pastries.', 400, 'whole_wheat_flour.jpg', 1, '.00Kg', 0, 1),
(45, 'Cayenne Pepper', 'Condiment/Spices', 'Fiery cayenne pepper powder for adding heat to dishes.', 180, 'cayenne_pepper.jpg', 1, '.00Kg', 0, 2),
(46, 'Red Wine Vinegar', 'Oil/Vinegars', 'Robust red wine vinegar perfect for salad dressings and marinades.', 300, 'red_wine_vinegar.jpg', 1, '.00Kg', 0, 3),
(47, 'Chickpea Flour', 'Other', 'Versatile chickpea flour for gluten-free cooking and baking.', 500, 'chickpea_flour.jpg', 1, '.00Kg', 0, 4),
(48, 'Ground Ginger', 'Condiment/Spices', 'Ground ginger powder adds warmth and flavor to sweet and savory dishes.', 220, 'ground_ginger.jpg', 1, '.00Kg', 0, 5),
(49, 'Honey', 'Other', 'Pure and natural honey sourced from local beekeepers.', 600, 'honey.jpg', 1, '.00Kg', 0, 6),
(50, 'Dried Basil', 'Condiment/Spices', 'Aromatic dried basil leaves for seasoning Italian dishes.', 150, 'dried_basil.jpg', 1, '.00Kg', 0, 7),
(51, 'Green Gram', 'Grains', 'Green Gram', 670, 'about_2.png', 1, '.00Kg', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `product_id`, `product_name`, `quantity`, `supplier_id`) VALUES
(2, 1, 'Rice (Red)', 105, 2),
(3, 4, 'Basmati Rice', 101, 1),
(4, 5, 'Red Lentils', 150, 2),
(5, 6, 'Cinnamon Powder', 80, 3),
(6, 7, 'Coconut Oil', 200, 4),
(7, 8, 'Black Tea', 110, 5),
(8, 9, 'Cashew Nuts', 180, 6),
(9, 10, 'Saffron Threads', 50, 7),
(10, 11, 'Palm Vinegar', 90, 8),
(11, 12, 'Jasmine Rice', 130, 9),
(12, 13, 'Turmeric Powder', 100, 10),
(13, 14, 'Extra Virgin Olive Oil', 70, 1),
(14, 15, 'Mango Puree', 180, 2),
(15, 16, 'Coriander Seeds', 110, 3),
(16, 17, 'White Vinegar', 200, 4),
(17, 18, 'Peanuts', 160, 5),
(18, 19, 'Cardamom Pods', 90, 6),
(19, 20, 'Apple Cider Vinegar', 120, 7),
(20, 21, 'Brown Sugar', 140, 8),
(21, 22, 'Fenugreek Seeds', 100, 9),
(22, 23, 'Balsamic Vinegar', 10, 10),
(23, 24, 'Quinoa', 110, 1),
(24, 25, 'Chili Powder', 150, 2),
(25, 26, 'Rice Bran Oil', 80, 3),
(26, 27, 'Sunflower Seeds', 170, 4),
(27, 28, 'Cumin Seeds', 120, 5),
(28, 29, 'Sesame Oil', 90, 6),
(29, 30, 'Chia Seeds', 110, 7),
(30, 31, 'Paprika Powder', 100, 8),
(31, 32, 'Rice Vinegar', 150, 9),
(32, 33, 'Sunflower Oil', 120, 10),
(33, 34, 'Poppy Seeds', 80, 1),
(34, 35, 'Red Wine Vinegar', 100, 2),
(35, 36, 'Brown Rice', 150, 3),
(36, 37, 'Mustard Seeds', 90, 4),
(37, 38, 'Honey', 200, 5),
(38, 39, 'Oregano', 110, 6),
(39, 40, 'Ghee', 70, 7),
(40, 41, 'Pistachios', 130, 8),
(41, 42, 'Vanilla Extract', 100, 9),
(42, 43, 'Whole Wheat Flour', 180, 10),
(43, 44, 'Rosemary', 50, 1),
(44, 45, 'Maple Syrup', 90, 2),
(45, 46, 'Almonds', 120, 3),
(46, 47, 'Basil Leaves', 160, 4),
(47, 48, 'Coconut Milk', 100, 5),
(48, 49, 'Soy Sauce', 110, 6),
(49, 50, 'Almond Oil', 60, 7),
(50, 2, 'Wheat Flour', 157, 2),
(51, 3, 'Dhal', 260, 1),
(52, 51, 'Green Gram', 10, 6);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `email`, `phone`, `address`) VALUES
(1, 'Sri Lanka Grocery Suppliers', 'info@srigrocery.lk', '+94771234567', '123 Galle Road, Colombo'),
(2, 'Ceylon Spices Exporters', 'ceylonspices@gmail.com', '+94772345678', '456 Kandy Road, Kandy'),
(3, 'Lanka Rice Mills', 'info@lankaricemills.com', '+94773456789', '789 Negombo Road, Kurunegala'),
(4, 'Sri Lanka Grocery Suppliers', 'info@srigrocery.lk', '+94771234567', '123 Galle Road, Colombo'),
(5, 'Colombo Food Traders', 'colombofood@example.com', '+94112345678', '456 Kandy Road, Colombo'),
(6, 'Ceylon Spice Exporters', 'ceylonspice@example.com', '+94765432109', '789 Negombo Street, Colombo'),
(7, 'Tea Leaf Growers Association', 'tealeafgrowers@example.com', '+94123456789', '101 Hill Country Road, Kandy'),
(8, 'Southern Seafood Exports', 'southernseafood@example.com', '+94711223344', '222 Hikkaduwa Beach, Galle'),
(9, 'Nuwaragala Tea Plantations', 'nuwaragala@example.com', '+94787654321', '333 Nuwara Eliya Road, Badulla'),
(10, 'Island Fresh Fruits Ltd.', 'islandfresh@example.com', '+94111234567', '444 Matale Street, Matale');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `user_type` varchar(50) NOT NULL DEFAULT 'user',
  `image` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `postal` varchar(20) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`, `image`, `address`, `city`, `postal`, `phone`) VALUES
(31, 'Lional', 'lionaljaya5@gmail.com', '0192023a7bbd73250516f069df18b500', 'user', '69280999_105835550796996_9042908239905161216_n.jpg', 'Rikillahaskada', 'Rikillagaskada', '20730', '0767275140'),
(32, 'Lional', 'lionaljayarathne@gmail.com', '0192023a7bbd73250516f069df18b500', 'user', '69280999_105835550796996_9042908239905161216_n.jpg', 'Rikillagaskada', 'Rikillagaskada', '20730', '0767275140');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(100) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `price` decimal(20,0) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `weight` decimal(10,0) DEFAULT NULL,
  `mweight` varchar(10) DEFAULT NULL,
  `discount` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `grns`
--
ALTER TABLE `grns`
  ADD PRIMARY KEY (`grn_number`),
  ADD KEY `fk_supplier_id` (`supplier_id`);

--
-- Indexes for table `grn_items`
--
ALTER TABLE `grn_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `grn_number` (`grn_number`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`invoice_number`),
  ADD UNIQUE KEY `unique_invoice_number` (`invoice_number`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `invoice_number` (`invoice_number`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `discount`
--
ALTER TABLE `discount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grns`
--
ALTER TABLE `grns`
  MODIFY `grn_number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1201;

--
-- AUTO_INCREMENT for table `grn_items`
--
ALTER TABLE `grn_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `invoice_number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=334;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `discount`
--
ALTER TABLE `discount`
  ADD CONSTRAINT `discount_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `grns`
--
ALTER TABLE `grns`
  ADD CONSTRAINT `fk_supplier_id` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`);

--
-- Constraints for table `grn_items`
--
ALTER TABLE `grn_items`
  ADD CONSTRAINT `grn_items_ibfk_1` FOREIGN KEY (`grn_number`) REFERENCES `grns` (`grn_number`);

--
-- Constraints for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD CONSTRAINT `invoice_items_ibfk_1` FOREIGN KEY (`invoice_number`) REFERENCES `invoices` (`invoice_number`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`);

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `stock_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`);

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
