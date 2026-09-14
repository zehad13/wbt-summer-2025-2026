SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `beverages` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(500) DEFAULT '',
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT 'default.jpg',
  `stock` int(11) NOT NULL DEFAULT 0,
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `beverages` (`id`, `category_id`, `name`, `description`, `price`, `image`, `stock`, `is_available`, `created_at`) VALUES
(1, 1, 'Cappuccino', 'Rich espresso topped with steamed milk foam.', 180.00, 'cappuccino.jpg', 25, 1, '2026-08-28 17:35:28'),
(2, 1, 'Iced Coffee', 'Chilled coffee served over ice, smooth and refreshing.', 160.00, 'iced-coffee.jpg', 30, 1, '2026-08-28 17:35:28'),
(3, 2, 'Milk Tea', 'Classic creamy milk tea, ChaJoy\'s signature drink.', 120.00, 'milk-tea.jpg', 40, 1, '2026-08-28 17:35:28'),
(4, 2, 'Green Tea', 'Light and refreshing antioxidant-rich green tea.', 110.00, 'green-tea.jpg', 35, 1, '2026-08-28 17:35:28'),
(5, 2, 'Lemon Tea', 'Zesty black tea with fresh lemon.', 100.00, 'lemon-tea.jpg', 0, 0, '2026-08-28 17:35:28'),
(6, 3, 'Mango Juice', 'Fresh mango blended into a sweet, tropical juice.', 150.00, 'mango-juice.jpg', 20, 1, '2026-08-28 17:35:28'),
(7, 3, 'Orange Juice', 'Freshly squeezed orange juice, packed with vitamin C.', 140.00, 'orange-juice.jpg', 18, 1, '2026-08-28 17:35:28'),
(8, 4, 'Cola', 'Chilled classic cola.', 80.00, 'cola.jpg', 50, 1, '2026-08-28 17:35:28'),
(9, 4, 'Lemon Soda', 'Fizzy soda with a splash of fresh lemon.', 90.00, 'lemon-soda.jpg', 22, 1, '2026-08-28 17:35:28');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `created_at`) VALUES
(1, 4, '2026-08-28 19:17:08'),
(2, 3, '2026-08-28 19:47:47');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `beverage_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `beverage_id`, `quantity`) VALUES
(1, 1, 6, 1),
(2, 1, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`) VALUES
(1, 'Coffee', '2026-08-28 17:35:28'),
(2, 'Tea', '2026-08-28 17:35:28'),
(3, 'Juice', '2026-08-28 17:35:28'),
(4, 'Soft Drinks', '2026-08-28 17:35:28');

-- --------------------------------------------------------

--
-- Table structure for table `deliveries`
--

CREATE TABLE `deliveries` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `delivery_person_id` int(11) DEFAULT NULL,
  `picked_up_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `status` enum('Waiting','Picked Up','Delivered') NOT NULL DEFAULT 'Waiting'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_code` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `payment_method` enum('COD','Online') NOT NULL DEFAULT 'COD',
  `subtotal` decimal(10,2) NOT NULL,
  `delivery_charge` decimal(10,2) NOT NULL DEFAULT 50.00,
  `total` decimal(10,2) NOT NULL,
  `status` enum('Pending','Preparing','Ready for Pickup','Out for Delivery','Delivered','Cancelled') NOT NULL DEFAULT 'Pending',
  `assigned_delivery_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `beverage_id` int(11) NOT NULL,
  `beverage_name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `method` enum('COD','Online') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('Pending','Paid') NOT NULL DEFAULT 'Pending',
  `paid_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `role` enum('customer','admin','delivery') NOT NULL DEFAULT 'customer',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `phone`, `password`, `address`, `role`, `status`, `created_at`) VALUES
(1, 'ChaJoy Admin', 'admin@chajoy.com', '01700000000', '$2y$10$MNh2KTFmAcr11IWw/xAJWeoK.97Hyj2F/bu8O.u6J9yD.0.zgnGr6', 'ChaJoy HQ, Dhaka', 'admin', 'active', '2026-08-28 17:35:28'),
(2, 'Zehad', 'delivery@chajoy.com', '01711111111', '$2y$10$MNh2KTFmAcr11IWw/xAJWeoK.97Hyj2F/bu8O.u6J9yD.0.zgnGr6', 'Mirpur, Dhaka', 'delivery', 'active', '2026-08-28 17:35:28'),
(3, 'Ummay Salma', 'customer@chajoy.com', '01722222222', '$2y$10$MNh2KTFmAcr11IWw/xAJWeoK.97Hyj2F/bu8O.u6J9yD.0.zgnGr6', 'Kuril, Dhaka', 'customer', 'active', '2026-08-28 17:35:28'),
(4, 'Mirza', 'test@chajoy.com', '01712345678', '$2y$10$MNh2KTFmAcr11IWw/xAJWeoK.97Hyj2F/bu8O.u6J9yD.0.zgnGr6', 'Dhaka', 'customer', 'active', '2026-08-28 19:17:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `beverages`
--
ALTER TABLE `beverages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `beverage_id` (`beverage_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `delivery_person_id` (`delivery_person_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_code` (`order_code`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `assigned_delivery_id` (`assigned_delivery_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `beverage_id` (`beverage_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `beverages`
--
ALTER TABLE `beverages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `deliveries`
--
ALTER TABLE `deliveries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `beverages`
--
ALTER TABLE `beverages`
  ADD CONSTRAINT `beverages_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`beverage_id`) REFERENCES `beverages` (`id`);

--
-- Constraints for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD CONSTRAINT `deliveries_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `deliveries_ibfk_2` FOREIGN KEY (`delivery_person_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`assigned_delivery_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`beverage_id`) REFERENCES `beverages` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
