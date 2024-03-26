-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Mar 26, 2024 at 06:33 PM
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
-- Database: `kronokat_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `due_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `description`, `start_date`, `due_date`) VALUES
(1, 'Communication Assignment', 'We need to to a whole lot of stuff for this project', '2024-03-17 20:05:14', '2024-03-31 20:05:14'),
(2, 'Project Alpha', 'This is the first project', '2024-04-01 08:00:00', '2024-06-30 17:00:00'),
(3, 'Project Beta', 'Project Beta is the second initiative', '2024-03-25 10:00:00', '2024-05-31 18:00:00'),
(4, 'Project Alpha', 'This is the first project', '2024-04-01 08:00:00', '2024-06-30 17:00:00'),
(5, 'Project Beta', 'Project Beta is the second initiative', '2024-03-25 10:00:00', '2024-05-31 18:00:00'),
(6, 'Project Gamma', 'Gamma Project is for testing purposes', '2024-04-05 09:00:00', '2024-07-15 16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'ADMIN'),
(2, 'USER'),
(4, 'TEAM_LEADER');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `location` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `due_date` datetime NOT NULL,
  `project_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `name`, `location`, `description`, `start_date`, `due_date`, `project_id`) VALUES
(10, 'create pdf', '', '', '2024-03-22 01:06:32', '2024-03-22 01:06:32', 1),
(11, 'Write report', '', 'Report 150-200 words', '2024-03-15 01:06:32', '2024-03-30 01:06:32', 1),
(12, 'Prepare presentation', 'Meeting Room A', 'Prepare slides for the upcoming meeting', '2024-03-16 10:00:00', '2024-03-29 10:00:00', 1),
(14, 'Conduct user testing', 'Lab 3', 'Test the usability of the new software features', '2024-03-18 13:30:00', '2024-03-27 13:30:00', 2),
(15, 'Interview candidates', 'HR Office', 'Conduct interviews for the vacant positions', '2024-03-19 08:00:00', '2024-03-26 08:00:00', 2),
(16, 'Update website content', '', 'Update the homepage content with latest news', '2024-03-20 15:00:00', '2024-03-25 15:00:00', 4),
(17, 'Test software updates', 'QA Lab', 'Test the latest software updates for bugs and issues', '2024-03-21 11:00:00', '2024-03-24 11:00:00', 3),
(18, 'Attend team meeting', 'Conference Room B', 'Weekly team meeting to discuss project progress', '2024-03-22 09:30:00', '2024-03-23 09:30:00', 3),
(19, 'A task with no project', 'Everywhere', 'This task has no project assigned, so no user-project connection has to be created.', '2023-03-15 12:45:14', '2024-03-22 17:15:14', NULL),
(20, 'Get a CO-OP', 'Algonquin college', 'We need to get a co-op during level 3', '2024-05-01 13:34:23', '2024-08-31 13:34:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `dob` date NOT NULL,
  `login` varchar(25) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` char(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `dob`, `login`, `email`, `password`) VALUES
(1, 'Andrea', 'Visani', '1992-02-28', 'AndreaV', 'visa0004@algonquinlive.com', 'passwordTest'),
(9, 'Anugrah', 'Rai', '2004-02-06', 'sasuraBAU', 'testmail@email.com', 'password'),
(10, 'Hussein', 'Majed', '1989-03-02', 'hkmajed', 'testmail@mail.com', 'password');

-- --------------------------------------------------------

--
-- Table structure for table `users_projects`
--

CREATE TABLE `users_projects` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_projects`
--

INSERT INTO `users_projects` (`id`, `project_id`, `user_id`) VALUES
(1, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users_roles`
--

CREATE TABLE `users_roles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_roles`
--

INSERT INTO `users_roles` (`id`, `user_id`, `role_id`) VALUES
(1, 10, 4),
(2, 1, 2),
(3, 9, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users_tasks`
--

CREATE TABLE `users_tasks` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_tasks`
--

INSERT INTO `users_tasks` (`id`, `task_id`, `user_id`) VALUES
(5, 10, 1),
(6, 10, 9),
(7, 11, 1),
(8, 12, 9),
(10, 14, 1),
(11, 15, 10),
(12, 16, 9),
(13, 17, 9),
(14, 18, 1),
(15, 18, 10),
(16, 18, 9),
(17, 15, 1),
(18, 19, 9),
(19, 20, 1),
(20, 20, 9),
(21, 20, 10);

--
-- Triggers `users_tasks`
--
DELIMITER $$
CREATE TRIGGER `assign_user_to_project` AFTER INSERT ON `users_tasks` FOR EACH ROW BEGIN
    DECLARE project_id_val INT;

    -- Get the project_id of the task
    SELECT project_id INTO project_id_val FROM tasks WHERE id = NEW.task_id;

    -- If the task has a project_id, insert a row into users_projects
    IF project_id_val IS NOT NULL THEN
        INSERT INTO users_projects (project_id, user_id) VALUES (project_id_val, NEW.user_id);
    END IF;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_projectID` (`project_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `login_2` (`login`);

--
-- Indexes for table `users_projects`
--
ALTER TABLE `users_projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `foreign_key_project_id` (`project_id`),
  ADD KEY `foreign_key_user_id` (`user_id`);

--
-- Indexes for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `foreign_key_role_id` (`role_id`),
  ADD KEY `foreign_key_userID` (`user_id`);

--
-- Indexes for table `users_tasks`
--
ALTER TABLE `users_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `foregin_task_id` (`task_id`),
  ADD KEY `foregin_user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users_projects`
--
ALTER TABLE `users_projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users_roles`
--
ALTER TABLE `users_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users_tasks`
--
ALTER TABLE `users_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `fk_projectID` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users_projects`
--
ALTER TABLE `users_projects`
  ADD CONSTRAINT `foreign_key_project_id` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `foreign_key_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD CONSTRAINT `foreign_key_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `foreign_key_userID` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users_tasks`
--
ALTER TABLE `users_tasks`
  ADD CONSTRAINT `foregin_task_id` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `foregin_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
