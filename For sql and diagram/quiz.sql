-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 28, 2017 at 03:55 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quiz`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `c_id` int(11) NOT NULL,
  `c_name` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`c_id`, `c_name`) VALUES
(1, 'java'),
(2, 'c');

-- --------------------------------------------------------

--
-- Table structure for table `cQuestion`
--

CREATE TABLE `cQuestion` (
  `id` int(11) NOT NULL,
  `question` char(255) NOT NULL,
  `option1` char(255) NOT NULL,
  `option2` char(255) NOT NULL,
  `option3` char(255) NOT NULL,
  `option4` char(255) NOT NULL,
  `answer` int(11) NOT NULL,
  `c_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cQuestion`
--

INSERT INTO `cQuestion` (`id`, `question`, `option1`, `option2`, `option3`, `option4`, `answer`, `c_id`) VALUES
(1, 'Which among the following is odd one out?', 'printf', 'fprintf', 'putchar', 'scanf', 4, 2),
(3, 'For a typical program, the input is taken using', 'scanf', 'Files', 'Command-line', 'All of the mentioned', 4, 2),
(4, 'What does the following command line signify?\r\n    prog1|prog2', 'It runs prog1 first, prog2 second', 'It runs prog2 first, prog1 second', 'It runs both the programs, pipes output of prog1 to input of prog2', 'It runs both the programs, pipes output of prog2 to input of prog1', 3, 2),
(5, 'The value of EOF is_____', '-1', '0', '1', '10', 1, 2),
(6, 'What is the use of getchar()?', 'The next input character each time it is called', 'EOF when it encounters end of file.', 'Both a & b', 'None of the mentioned', 3, 2),
(7, 'Which is true?', 'The symbolic constant EOF is defined in <stdio.h>', 'The value is -1', 'Both a & b', 'None of the above', 3, 2),
(8, 'What is the return value of putchar()?', 'The character written', 'EOF if an error occurs', 'Nothing', 'Both a & b', 4, 2),
(9, 'The number of digits present after decimal in float is________.', '1', '3', '6', '16', 3, 2),
(10, 'typedef which of the following may create problem in the program', ';', 'printf/scanf', 'Arithmetic operators', 'All of the mentioned', 4, 2),
(11, 'In a 32-bit compiler, which 2 types have same size?', 'char and short', 'short and int', 'int and float', 'float and double', 3, 2),
(12, 'What is the size of float in a 32-bit compiler?', '1', '2', '4', '8', 3, 2),
(13, 'Loss in precision occurs for typecasting from____________.', 'char to short', 'float to double', 'long to float', 'float to int', 4, 2),
(14, 'Which of the following data types are accepted while declaring bit-fields?', 'char', 'float', 'double', 'None of the mentioned', 1, 2),
(15, 'Which of the following reduces the size of a structure?', 'union', 'bit-fields', 'malloc', 'None of the mentioned', 2, 2),
(16, 'Which of the following is not allowed?', 'Arrays of bit fields', 'Pointers to bit fields', 'Functions returning bit fields', 'None of the mentioned', 4, 2),
(17, 'Bit fields can only be declared as part of a structure.', 'false', 'true', 'Nothing', 'Varies', 2, 2),
(18, 'The following declarations in order are\r\n    short a : 17;\r\n    int long y : 33;', 'Legal, legal', 'Legal, illegal', 'Illegal, illegal', 'Illegal, legal', 3, 2),
(20, 'Which among the following is never possible as an output for float?', '3.666666', '3.666', '3', 'None of the mentioned', 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `javaQuestion`
--

CREATE TABLE `javaQuestion` (
  `id` int(11) NOT NULL,
  `question` varchar(1000) NOT NULL,
  `option1` varchar(1000) NOT NULL,
  `option2` varchar(1000) NOT NULL,
  `option3` varchar(1000) NOT NULL,
  `option4` varchar(1000) NOT NULL,
  `answer` int(11) NOT NULL,
  `c_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `javaQuestion`
--

INSERT INTO `javaQuestion` (`id`, `question`, `option1`, `option2`, `option3`, `option4`, `answer`, `c_id`) VALUES
(1, 'What is the range of data type short in Java?', '-128 to 127', '-32768 to 32767', '-2147483648 to 2147483647', 'None of the mentioned', 2, 1),
(2, 'What is the range of data type byte in Java?', '-128 to 127', '-32768 to 32767', '-2147483648 to 2147483647', 'None of the mentioned', 1, 1),
(3, 'An expression involving byte, int, and literal numbers is promoted to which of these?', 'int', 'long', 'byte', 'float', 1, 1),
(4, 'Which of these literals can be contained in a data type float variable?', '1.7e-308', '3.4e-038', '1.7e+308', '3.4e-050', 2, 1),
(5, 'Which data type value is returned by all transcendental math functions?', 'int', 'float', 'double', 'long', 3, 1),
(6, 'What is the numerical range of a char in Java?', '-128 to 127', '0 to 256', '0 to 32767', '0 to 65535', 4, 1),
(7, 'Which of these coding types is used for data type characters in Java?', 'ASCII', 'ISO-LATIN-1', 'UNICODE', 'None of the mentioned', 3, 1),
(8, 'Which of these values can a boolean variable contain?', 'True & False', '0 & 1', 'Any integer value', 'true', 1, 1),
(9, 'Which of these occupy first 0 to 127 in Unicode character set used for characters in Java?', 'ASCII', 'ISO-LATIN-1', 'None of the mentioned', 'ASCII and ISO-LATIN1', 4, 1),
(10, 'Which of these is data type long literal?', '0x99fffL', 'ABCDEFG', '0x99fffa', '99671246', 1, 1),
(11, 'Which of these can be returned by the operator & ?', 'Integer', 'Boolean', 'Character', 'Integer or Boolean', 4, 1),
(12, 'Literals in java must be appended by which of these?', 'L', 'l', 'D', 'L and I', 4, 1),
(13, 'Literal can be of which of these data types?', 'integer', 'float', 'boolean', 'all of the mentioned', 4, 1),
(14, 'Which of these is necessary condition for automatic type conversion in Java?', 'The destination type is smaller than source type.', 'The destination type is larger than source type.', 'The destination type can be larger or smaller than source type.', 'None of the mentioned', 2, 1),
(15, 'What is the prototype of the default constructor of this class?\r\npublic class prototype { }', 'prototype( )', 'prototype(void)', 'public prototype(void)', 'public prototype( )', 4, 1),
(16, 'If an expression contains double, int, float, long, then whole expression will promoted into which of these data types?', 'long', 'int', 'double', 'float', 3, 1),
(17, 'What is Truncation is Java?', 'Floating-point value assigned to an integer type.', 'Integer value assigned to floating type.', 'Floating-point value assigned to an Floating type.', 'Integer value assigned to floating type.', 1, 1),
(18, 'Which of these operators is used to allocate memory to array variable in Java?', 'malloc', 'alloc', 'new', 'new malloc', 3, 1),
(19, 'Which of these is necessary to specify at time of array initialization?', 'Row', 'Column', 'Both Row and Column', 'None of the mentioned', 1, 1),
(20, 'What is the stored in the object obj in following lines of code?\r\nbox obj;', 'Memory address of allocated memory of object.', 'NULL', 'Any arbitrary pointer', 'Garbage', 2, 1),
(21, 'Which among the following is odd one out?', 'printf', 'fprintf', 'putchar', 'scanf', 4, 2),
(22, 'For a typical program, the input is taken using', 'scanf', 'Files', 'Command-line', 'All of the mentioned', 4, 2),
(23, 'What does the following command line signify?\r\n    prog1|prog2', 'It runs prog1 first, prog2 second', 'It runs prog2 first, prog1 second', 'It runs both the programs, pipes output of prog1 to input of prog2', 'It runs both the programs, pipes output of prog2 to input of prog1', 3, 2),
(24, 'What is the default return-type of getchar()?', 'char', 'int', 'char *', 'Reading character doesn’t require a return-type', 2, 2),
(25, 'The value of EOF is_____', '-1', '0', '1', '10', 1, 2),
(26, 'What is the use of getchar()?', 'The next input character each time it is called', 'EOF when it encounters end of file.', 'Both a & b', 'None of the mentioned', 3, 2),
(27, 'Which is true?', 'The symbolic constant EOF is defined in <stdio.h>', 'The value is -1', 'Both a & b', 'None of the above', 3, 2),
(28, 'What is the return value of putchar()?', 'The character written', 'EOF if an error occurs', 'Nothing', 'Both a & b', 4, 2),
(29, 'The number of digits present after decimal in float is________.', '1', '3', '6', '16', 3, 2),
(30, 'typedef which of the following may create problem in the program', ';', 'printf/scanf', 'Arithmetic operators', 'All of the mentioned', 4, 2),
(31, 'In a 32-bit compiler, which 2 types have same size?', 'char and short', 'short and int', 'int and float', 'float and double', 3, 2),
(32, 'What is the size of float in a 32-bit compiler?', '1', '2', '4', '8', 3, 2),
(33, 'Loss in precision occurs for typecasting from____________.', 'char to short', 'float to double', 'long to float', 'float to int', 4, 2),
(34, 'Which of the following data types are accepted while declaring bit-fields?', 'char', 'float', 'double', 'None of the mentioned', 1, 2),
(35, 'Which of the following reduces the size of a structure?', 'union', 'bit-fields', 'malloc', 'None of the mentioned', 2, 2),
(36, 'Which of the following is not allowed?', 'Arrays of bit fields', 'Pointers to bit fields', 'Functions returning bit fields', 'None of the mentioned', 4, 2),
(37, 'Bit fields can only be declared as part of a structure.', 'false', 'true', 'Nothing', 'Varies', 2, 2),
(38, 'The following declarations in order are\r\n    short a : 17;\r\n    int long y : 33;', 'Legal, legal', 'Legal, illegal', 'Illegal, illegal', 'Illegal, legal', 3, 2),
(39, 'Which of the given option is the correct method for initialization?\r\n    typedef char *string;', '*string *p = “Hello”;', 'string p = “Hello”;', '*string p = ‘A’;', 'Not more than one space should be given when using typedef', 2, 2),
(40, 'Which among the following is never possible as an output for float?', '3.666666', '3.666', '3', 'None of the mentioned', 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `score`
--

CREATE TABLE `score` (
  `s_id` int(11) NOT NULL,
  `score` int(128) NOT NULL,
  `attempt` int(128) NOT NULL,
  `id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `score`
--

INSERT INTO `score` (`s_id`, `score`, `attempt`, `id`, `c_id`) VALUES
(8, 0, 1, 1, 1),
(9, 0, 2, 1, 1),
(10, 0, 3, 1, 1),
(11, 0, 4, 5, 1),
(12, 4, 5, 5, 1),
(13, 1, 6, 5, 1),
(14, 1, 7, 5, 1),
(15, 5, 1, 5, 2),
(16, 1, 2, 5, 2),
(17, 1, 3, 5, 2),
(18, 0, 8, 1, 1),
(19, 1, 9, 1, 1),
(21, 6, 11, 1, 1),
(22, 6, 4, 1, 2),
(23, 6, 5, 1, 2),
(24, 6, 12, 1, 1),
(26, 4, 6, 1, 2),
(27, 2, 7, 1, 2),
(28, 5, 8, 1, 2),
(29, 6, 9, 1, 2),
(31, 4, 10, 1, 2),
(32, 10, 11, 13, 2),
(33, 9, 13, 13, 1);

-- --------------------------------------------------------

--
-- Table structure for table `userinfo`
--

CREATE TABLE `userinfo` (
  `id` int(11) NOT NULL,
  `firstname` varchar(128) NOT NULL,
  `lastname` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `pwd` varchar(128) NOT NULL,
  `phone` varchar(128) NOT NULL,
  `Address` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userinfo`
--

INSERT INTO `userinfo` (`id`, `firstname`, `lastname`, `email`, `pwd`, `phone`, `Address`) VALUES
(1, 'Milind', 'Patel', 'milindpatel4416@gmail.com', '9409251958', '647-273-1722', '34,loft house square'),
(2, 'Maheshbhai', 'Patel', 'maheshkumar3959@gmail.com', 'mahesh3959', '9427403993', '1,Jalaram Park,Mogri'),
(5, 'Milind', 'm', 'q@g.com', '1', '1', '1'),
(11, '', '', '', '', '', ''),
(12, 'q', 'q', 'q@f.com', '1', '1', '1'),
(13, 'Kunal', 'Panchal', 'kunalhp26@gmail.com', 'kunal', '4165694074', '1827987');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `cQuestion`
--
ALTER TABLE `cQuestion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `c_id` (`c_id`);

--
-- Indexes for table `javaQuestion`
--
ALTER TABLE `javaQuestion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `c_id` (`c_id`);

--
-- Indexes for table `score`
--
ALTER TABLE `score`
  ADD PRIMARY KEY (`s_id`),
  ADD KEY `id` (`id`),
  ADD KEY `c_id` (`c_id`);

--
-- Indexes for table `userinfo`
--
ALTER TABLE `userinfo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `cQuestion`
--
ALTER TABLE `cQuestion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `javaQuestion`
--
ALTER TABLE `javaQuestion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `score`
--
ALTER TABLE `score`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `userinfo`
--
ALTER TABLE `userinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `cQuestion`
--
ALTER TABLE `cQuestion`
  ADD CONSTRAINT `cquestion_ibfk_1` FOREIGN KEY (`c_id`) REFERENCES `category` (`c_id`);

--
-- Constraints for table `javaQuestion`
--
ALTER TABLE `javaQuestion`
  ADD CONSTRAINT `javaquestion_ibfk_1` FOREIGN KEY (`c_id`) REFERENCES `category` (`c_id`),
  ADD CONSTRAINT `javaquestion_ibfk_2` FOREIGN KEY (`c_id`) REFERENCES `category` (`c_id`);

--
-- Constraints for table `score`
--
ALTER TABLE `score`
  ADD CONSTRAINT `score_ibfk_1` FOREIGN KEY (`id`) REFERENCES `userinfo` (`id`),
  ADD CONSTRAINT `score_ibfk_2` FOREIGN KEY (`c_id`) REFERENCES `category` (`c_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
