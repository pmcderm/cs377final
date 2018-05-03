
CREATE TABLE `Class` (
  `Cnumber` int(10) NOT NULL,
  `Cname` varchar(100) NOT NULL,
  `SectionNum` int(10) NOT NULL,
  `Semester` varchar(100) NOT NULL,
  `Year` int(10) NOT NULL,
  `Instr_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `Instructor` (
  `Instr_id` varchar(20) NOT NULL,
  `Fname` varchar(100) NOT NULL,
  `Lname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `Question` (
  `Sid` varchar(20) NOT NULL,
  `Cnumber` int(5) NOT NULL,
  `Qnumber` int(4) NOT NULL,
  `Answer` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `Question_Evaluation` (
  `Qnumber` int(20) NOT NULL,
  `Qcontent` varchar(500) NOT NULL,
  `Qtype` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `Student` (
  `Sid` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `Student_Class` (
  `Sid` varchar(20) NOT NULL,
  `Cnumber` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `Class`
  ADD PRIMARY KEY (`Cnumber`),
  ADD KEY `Instr_id` (`Instr_id`);

ALTER TABLE `Instructor`
  ADD PRIMARY KEY (`Instr_id`);

ALTER TABLE `Question`
  ADD KEY `Sid` (`Sid`),
  ADD KEY `Cnumber` (`Cnumber`),
  ADD KEY `Qnumber` (`Qnumber`);

ALTER TABLE `Question_Evaluation`
  ADD PRIMARY KEY (`Qnumber`);

ALTER TABLE `Student`
  ADD PRIMARY KEY (`Sid`);

ALTER TABLE `Student_Class`
  ADD KEY `Sid` (`Sid`),
  ADD KEY `Cnumber` (`Cnumber`),
  ADD KEY `Sid_2` (`Sid`);


ALTER TABLE `Class`
  ADD CONSTRAINT `Instructor_id` FOREIGN KEY (`Instr_id`) REFERENCES `Instructor` (`Instr_id`);

ALTER TABLE `Question`
  ADD CONSTRAINT `Cnumber` FOREIGN KEY (`Cnumber`) REFERENCES `Class` (`Cnumber`),
  ADD CONSTRAINT `Qnumber` FOREIGN KEY (`Qnumber`) REFERENCES `Question_Evaluation` (`Qnumber`),
  ADD CONSTRAINT `Sid` FOREIGN KEY (`Sid`) REFERENCES `Student` (`Sid`);

ALTER TABLE `Student_Class`
  ADD CONSTRAINT `Cnumber from Class Table` FOREIGN KEY (`Cnumber`) REFERENCES `Class` (`Cnumber`),
  ADD CONSTRAINT `Sid_Student_Class` FOREIGN KEY (`Sid`) REFERENCES `Student` (`Sid`);


