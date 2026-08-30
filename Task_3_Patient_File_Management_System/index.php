<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Registration</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">

        <header>
            <h1>Student Registration</h1>
            <p>Enter your registration details</p>
        </header>

        <main class="form-card">

            <h2>Registration Form</h2>

            <form action="process.php" method="POST">

                <div class="form-group">
                    <label for="name">Student Name</label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Enter student name"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="register_number">
                        Register Number
                    </label>

                    <input
                        type="text"
                        id="register_number"
                        name="register_number"
                        placeholder="Enter register number"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Enter email address"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="course">Course</label>

                    <select id="course" name="course" required>

                        <option value="">
                            -- Select Course --
                        </option>

                        <option value="B.Sc Computer Science">
                            B.Sc Computer Science
                        </option>

                        <option value="BCA">
                            BCA
                        </option>

                        <option value="B.Sc Information Technology">
                            B.Sc Information Technology
                        </option>

                        <option value="B.Com Computer Applications">
                            B.Com Computer Applications
                        </option>

                    </select>
                </div>

                <div class="form-group">
                    <label for="year">Year</label>

                    <select id="year" name="year" required>

                        <option value="">
                            -- Select Year --
                        </option>

                        <option value="I Year">
                            I Year
                        </option>

                        <option value="II Year">
                            II Year
                        </option>

                        <option value="III Year">
                            III Year
                        </option>

                    </select>
                </div>

                <button type="submit">
                    Register Student
                </button>

            </form>

        </main>

    </div>

</body>

</html>