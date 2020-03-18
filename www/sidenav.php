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
                <ul class="collapse list-unstyled" id="enterprisesSubmenu">
                    <li>
                        <a href="registerEnterprise.php">New Enterprise</a>
                    </li>
                    <li>
                        <a href="/myEnterprises">My Enterprises</a>
                    </li>
                    
                </ul>
            </li>
           
            <li class="active">
                <a href="#studentsSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Students</a>
                <ul class="collapse list-unstyled" id="studentSubmenu">
                    <li>
                        <a href="/registerStudent">New Student</a>
                    </li>
                    <li>
                        <a href="/myStudents">My Students</a>
                    </li>
                    
                </ul>
            </li>
            
           
        </ul>
        
    </nav>
<?php } ?>