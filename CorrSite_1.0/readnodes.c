/*********************************************************
/                                                        /
/ source code copyright University of Pittsburgh,        /
/ released under the terms of the GPL, see license.txt   /
/                                                        /
/********************************************************/

void readnodes (char *pdbfile , net *netobj , char chain , int inputmodel , char **nodetypes , int nnodetypes) {

/*************************************************************
//  
// Get a PDB file and read all nodes it into a structure. A new version (11/2006.
//
// Eran 11/2006
//
/*************************************************************/

FILE *fp ;
char atomtype[5] ;
char buffer[100] ;
int est_num_of_residues=0 ;
int previous_res_num ;
int index_of_node  ;
char field[7] ; 
char model[5]="   0" ; 
char rescoornum[5] ;
char resname[4] ;
char atomindex[5] ;
int rescoornumint , atomindexint ;
int modeli= 0 ;
char insertion_code , previous_insertion_code , cur_chain ;
char alternative ;
char xs[9] , ys[9] , zs[9] , bs[7] , occus[7] ;
float xf , yf , zf , bf , occuf ;
int i , found ;

// open file and make first pass to count residues

fp = fopen(pdbfile , "r") ;
while (fgets(buffer, sizeof(buffer),fp)) {
	strncpy (atomtype , buffer+12 , 4) ;     // fields 12-15
	atomtype[4] = '\0' ;
	if (!strcmp(atomtype , " CA "))  est_num_of_residues++ ;
	if (!strcmp(atomtype , " C2 "))  est_num_of_residues++ ;
}

// close file (1) 

fclose (fp) ;

// allocate memory for the residue array

netobj->nodes = malloc ((est_num_of_residues+200)*sizeof(node));

// open again

fp = fopen(pdbfile , "r") ;
index_of_node = 0 ;
while (fgets(buffer, sizeof(buffer),fp)) {
	strncpy (field , buffer , 6) ;     // fields 0-6
	field[6] = '\0' ;
	if (!strcmp(field , "MODEL ")) {  
		strncpy (model , buffer+10 , 4) ;     // fields 0-6
		model[4] = '\0' ;
		modeli = atoi(model) ;
	}
	if ((!strcmp(field , "ATOM  ")) || (!strcmp(field , "HETATM"))) {   // if an ATOM/HETATM record, insert the data to the object
	   cur_chain = buffer[21] ;
	   strncpy (resname , buffer+17 , 3) ;        // fields 17-19
           alternative = buffer[16] ;
           if ((alternative != ' ') && (alternative != 'A')) continue ;  // only alternative A/' ' is read
	   if (!checkmodifiedaa(resname)) continue ;
	   if ((modeli != inputmodel) && (inputmodel != 0)) continue ;
	   if ((cur_chain == chain) || (chain == '*')) {
		strncpy (atomtype   , buffer+12 , 4) ;     // fields 12-15
		atomtype[4] = '\0' ;
		
		// Now loop to check if this is node. If yes, insert to the structure.
		found = 0 ;
		for (i=0 ; i < nnodetypes ; i++) {
			if (!strcmp(atomtype, nodetypes[i])) found = 1 ;
		}
		if (found == 0) continue ; 		
		strncpy (rescoornum , buffer+22 , 4) ;     // fields 22-25
		insertion_code = buffer[26] ;
		rescoornum[4] = '\0' ;
		rescoornumint = atoi (rescoornum) ;
		resname[3] = '\0' ;
		insertion_code = buffer[26] ;
		strcpy (netobj->nodes[index_of_node].resname , resname) ;
		netobj->nodes[index_of_node].pdbcoornum = rescoornumint ;
		netobj->nodes[index_of_node].insertioncode = insertion_code ;
		netobj->nodes[index_of_node].chain = cur_chain ;
		netobj->nodes[index_of_node].model = modeli ;
					
		strncpy (atomindex   , buffer+6 , 5) ;     // fields 6-10
		atomindex[5] = '\0' ;
		atomindexint  = atoi(atomindex) ;
		strncpy (xs , buffer+30 , 8) ;        // fields 30-37
		xs[8] = '\0' ;
		xf = atof(xs) ;
		strncpy (ys , buffer+38 , 8) ;        // fields 38-45
		ys[8] = '\0' ;
		yf = atof(ys) ;
		strncpy (zs , buffer+46 , 8) ;        // fields 46-53
		zs[8] = '\0' ;
		zf = atof(zs) ;
		strncpy (occus , buffer+54 , 6) ;     // fields 54-59
		occus[6] = '\0' ;
		occuf = atof(occus) ;
		strncpy (bs , buffer+60 , 6) ;        // fields 60-65
		bs[6] = '\0' ;
		bf = atof(bs) ;
		
		// Insert information for the atoms:
		
		strcpy (netobj->nodes[index_of_node].atomname , atomtype) ; ;
		netobj->nodes[index_of_node].alter = alternative ;
		netobj->nodes[index_of_node].occupancy = occuf ;
		netobj->nodes[index_of_node].coor[0] = xf ;
		netobj->nodes[index_of_node].coor[1] = yf ;
		netobj->nodes[index_of_node].coor[2] = zf ;
		netobj->nodes[index_of_node].bfac = bf ;
		index_of_node++ ;
	    }
	}
}


netobj->numnodes = index_of_node ;
strcpy (netobj->file , pdbfile) ;
// printf ("file is %s\n" , netobj->file) ;

fclose (fp) ;

}
