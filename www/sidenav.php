<?php if (isset($user)) { ?>
    <nav id="sidenav" class="collapsed">
        <div class="text-right">
            <button type="button" id="sidenavCollapse" class="btn btn-primary text-secondary">
                <i class="fa fa-bars"></i>
            </button>
        </div>
        <ul class="list-unstyled">
            <li>
                <a href="#enterprisesSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Enterprises</a>
                <ul class="collapse list-unstyled my-0 ml-3" id="enterprisesSubmenu">
                    <li>
                        <a href="registerEnterprise.php">New Enterprise</a>
                    </li>
                    <li>
                        <a href="myEnterprises.php">My Enterprises</a>
                    </li>
                    <?php
                     if($_SESSION["user"]["role"]==='ADMIN'){
                    ?>
                    <li>
                        <a href="registerEnterpriseType.php">New Enterprise Type</a>
                    </li>
                    <?php
                     }
                    ?>
                    
                </ul>
            </li>
            <li>
                <a href="#studentsSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Students</a>
                <ul class="collapse list-unstyled my-0 ml-3" id="studentsSubmenu">
                    <li>
                        <a href="registerStudent.php">New Student</a>
                    </li>
                    <li>
                        <a href="myStudents.php">My Students</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#institutionsSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Institutions</a>
                <ul class="collapse list-unstyled my-0 ml-3" id="institutionsSubmenu">
                    <li>
                        <a href="myInstitution.php">My Institution</a>
                    </li>
                    <?php
                     if($_SESSION["user"]["role"]==='ADMIN'){
                    ?>
                    <li>
                        <a href="registerInstitutionType.php">New Institution Type</a>
                    </li>
                    <?php
                     }
                    ?>
                </ul>
            </li>
            <li>
                <a href="#mobilitiesSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Mobilities</a>
                <ul class="collapse list-unstyled my-0 ml-3" id="mobilitiesSubmenu">
                    <li>
                        <a href="registerEnterpriseMobility.php">New Enterprise Mobility</a>
                    </li>
                    <li>
                        <a href="registerInstitutionMobility.php">New Institution Mobility</a>
                    </li>
                    <li><a href="myMobilities.php">My Mobilities</a></li>
                    
                    <?php
                     if($_SESSION["user"]["role"]==='ADMIN'){
                    ?>
                    <li>
                        <a href="findMobilities.php">Find mobilities</a>
                    </li>
                    <?php
                     }
                     ?>
                </ul>
            </li>
           
            <li>
                <a href="#specialtiesSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Specialties</a>
                <ul class="collapse list-unstyled my-0 ml-3" id="specialtiesSubmenu">
                    <li>
                        <a href="registerStudentSpecialty.php">New student Specialty</a>
                    </li>
                    <li>
                        <a href="registerInstitutionSpecialty.php">New Institution Specialty</a>
                    </li>
                    <li>
                        <a href="registerEnterpriseSpecialty.php">New Enterprise Specialty</a>
                    </li>
                     <?php
                    if($_SESSION["user"]["role"]==='ADMIN'){
                    ?>
                    <li>
                        <a href="registerSpecialty.php">New Specialty</a>
                    </li>
                    <li>
                        <a href="allSpecialties.php">All Specialties</a>
                    </li>
                </ul>
            </li>
            <?php
            }
            ?>
        </ul>
    </nav>
<?php } ?>