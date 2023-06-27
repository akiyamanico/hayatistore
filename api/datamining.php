<?php
								  $sql_cek_1 = "SELECT Iterasi_1 FROM proses_mining WHERE 
								  			Iterasi_1 = 1 AND Iterasi_2 = 0 OR
										 	Iterasi_1 = 0 AND Iterasi_2 = 1";
								  $cs1 = mysql_num_rows(mysql_query($sql_cek_1));
								  if ($cs1 == 0){ 
										?> 
                                        <th colspan="2" style="text-align:center">Iterasi 1</th> 
                                        <th colspan="2" style="text-align:center">Iterasi 2</th> 
                                        <?php
								  }else if ($cs1 > 0) {
									  $sql_cek_2 = "SELECT Iterasi_2 FROM proses_mining WHERE 
								  			Iterasi_2 = 1 AND Iterasi_3 = 0 OR
										 	Iterasi_2 = 0 AND Iterasi_3 = 1";
								  	  $cs2 = mysql_num_rows(mysql_query($sql_cek_2));
									  
									  if ($cs2 == 0){ 
										  ?> 
                                          <th colspan="2" style="text-align:center">Iterasi 1</th> 
                                          <th colspan="2" style="text-align:center">Iterasi 2</th>
                                          <th colspan="2" style="text-align:center">Iterasi 3</th>
										  <?php 
									  }else if ($cs2 > 0) {
										  $sql_cek_3 = "SELECT Iterasi_3 FROM proses_mining WHERE 
											  Iterasi_3 = 1 AND Iterasi_4 = 0 OR
											  Iterasi_3 = 0 AND Iterasi_4 = 1";
								  	  	  $cs3 = mysql_num_rows(mysql_query($sql_cek_3));
										  if ($cs3 == 0){ 
										  	  ?> 
                                              <th colspan="2" style="text-align:center">Iterasi 1</th> 
                                          	  <th colspan="2" style="text-align:center">Iterasi 2</th>
                                          	  <th colspan="2" style="text-align:center">Iterasi 3</th>
                                              <th colspan="2" style="text-align:center">Iterasi 4</th> 
											  <?php 
										  }else if ($cs3 > 0) {
										  	  $sql_cek_4 = "SELECT Iterasi_4 FROM proses_mining WHERE 
											  	  Iterasi_4 = 1 AND Iterasi_5 = 0 OR
											  	  Iterasi_4 = 0 AND Iterasi_5 = 1";
											  $cs4 = mysql_num_rows(mysql_query($sql_cek_4));
											  if ($cs4 == 0){ 
													?> 
													<th colspan="2" style="text-align:center">Iterasi 1</th> 
                                          	  		<th colspan="2" style="text-align:center">Iterasi 2</th>
                                          	  		<th colspan="2" style="text-align:center">Iterasi 3</th>
                                              		<th colspan="2" style="text-align:center">Iterasi 4</th>
                                                    <th colspan="2" style="text-align:center">Iterasi 5</th>
													<?php 
											  } else if ($cs4 > 0) {
												  $sql_cek_5 = "SELECT Iterasi_5 FROM proses_mining WHERE 
													  Iterasi_5 = 1 AND Iterasi_6 = 0 OR
													  Iterasi_5 = 0 AND Iterasi_6 = 1";
												  $cs5 = mysql_num_rows(mysql_query($sql_cek_5));
											  	  if ($cs5 == 0){ 
														?> 
														<th colspan="2" style="text-align:center">Iterasi 1</th> 
                                          	  			<th colspan="2" style="text-align:center">Iterasi 2</th>
                                          	  			<th colspan="2" style="text-align:center">Iterasi 3</th>
                                              			<th colspan="2" style="text-align:center">Iterasi 4</th>
                                                    	<th colspan="2" style="text-align:center">Iterasi 5</th>
                                                        <th colspan="2" style="text-align:center">Iterasi 6</th>
														<?php 
											  	  } else if ($cs5 > 0) {
													  $sql_cek_6 = "SELECT Iterasi_6 FROM proses_mining WHERE 
														  Iterasi_6 = 1 AND Iterasi_7 = 0 OR
														  Iterasi_6 = 0 AND Iterasi_7 = 1";
													  $cs6 = mysql_num_rows(mysql_query($sql_cek_6));
													  if ($cs6 == 0){ 
															?> 
															<th colspan="2" style="text-align:center">Iterasi 1</th> 
                                          	  				<th colspan="2" style="text-align:center">Iterasi 2</th>
                                          	  				<th colspan="2" style="text-align:center">Iterasi 3</th>
                                              				<th colspan="2" style="text-align:center">Iterasi 4</th>
                                                    		<th colspan="2" style="text-align:center">Iterasi 5</th>
                                                        	<th colspan="2" style="text-align:center">Iterasi 6</th>
                                                            <th colspan="2" style="text-align:center">Iterasi 7</th>  
															<?php 
													  }
												  }
											  }
										  }
									  }
								  }
								  ?>