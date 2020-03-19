<?php if (isset($user)) { ?>
    <nav id="sidenav" class="collapsed">
        <div class="text-right">
            <button type="button" id="sidenavCollapse" class="btn btn-primary text-secondary">
                <i class="fa fa-bars"></i>
            </button>
        </div>
        <ul class="list-unstyled">
            <li class="active">
                <a href="#enterprisesSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Enterprises</a>
                <ul class="collapse list-unstyled " id="enterprisesSubmenu">
                    <li>
                        <a href="registerEnterprise.php">New Enterprise</a>
                    </li>
                    <li>
                        <a href="myEnterprises.php">My Enterprises</a>
                    </li>
                    
                </ul>
            </li>
           
            <li>
                <a href="#studentsSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Students</a>
                <ul class="collapse list-unstyled" id="studentSubmenu">
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
                <ul class="collapse list-unstyled" id="studentSubmenu">
                    <li>
                        <a href="myInstitution.php">My Institution</a>
                    </li>
                    
                    
                </ul>
            </li>
            
            <li>
                <a href="#mobilitiesSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Mobilities</a>
                <ul class="collapse list-unstyled" id="studentSubmenu">
                    <li>
                        <a href="registerEnterpriseMobility.php">New Enterprise Mobility</a>
                    </li>
                    <li>
                        <a href="registerInstitutionMobility.php">New Institution Mobility</a>
                    </li>
                    <li><a href="myMobilities.php">My Mobilities</a></li>
                    
                </ul>
            </li>
            <?php
            if($_SESSION["user"]["role"]==='ADMIN'){
                
            
            ?>
            <li>
                <a href="#specialtiesSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Specialties</a>
                <ul class="collapse list-unstyled" id="studentSubmenu">
                    <li>
                        <a href="registerSpecialty.php">New specialty</a>
                    </li>
                    <li>
                        <a href="allSpecialties.php">All specialties</a>
                    </li>
                    
                    
                </ul>
            </li>
            <?php
            }
            ?>
           
        </ul>
        
    </nav>
<?php } ?>