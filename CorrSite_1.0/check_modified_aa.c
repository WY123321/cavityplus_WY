/*********************************************************
/                                                        /
/ source code copyright University of Pittsburgh,        /
/ released under the terms of the GPL, see license.txt   /
/                                                        /
/********************************************************/


int checkmodifiedaa(char *name)  {

/****************************************************************************
//
// Get a name of a chemical group (3 letter code) and check
// if this is a modified amino acid. return one letter code of 
// the 
//
// Eran, 9/2005
//
****************************************************************************/

int i ;
char *ResCode[] = {

  // standard aminoacids

  "ALA A",  // Alanine
  "ARG R",  // Arginine
  "ASN N",  // Asparagine
  "ASP D",  // Aspartic acid (Aspartate)
  "CYS C",  // Cysteine
  "GLN Q",  // Glutamine
  "GLU E",  // Glutamic acid (Glutamate)
  "GLY G",  // Glycine
  "HIS H",  // Histidine
  "ILE I",  // Isoleucine
  "LEU L",  // Leucine
  "LYS K",  // Lysine
  "MET M",  // Methionine
  "PHE F",  // Phenylalanine
  "PRO P",  // Proline
  "SER S",  // Serine
  "THR T",  // Threonine
  "TRP W",  // Tryptophan
  "TYR Y",  // Tyrosine
  "VAL V",  // Valine
  "ASX B",  // Aspartic acid or Asparagine
  "GLX Z",  // Glutamine or Glutamic acid.
  //  ???     X       Any amino acid.

  // other

  "1PA A",   "1PI A",   "2AS D",   "2ML L",   "2MR R",   "3GA A",
  "5HP E",   "ACB D",   "ACL R",   "AGM R",   "AHB D",   "ALM A",
  "ALN A",   "ALO T",   "ALT A",   "ALY K",   "APH A",   "APM A",
  "AR2 R",   "ARM R",   "ARO R",   "ASA D",   "ASB D",   "ASI D",
  "ASK D",   "ASL D",   "ASQ D",   "AYA A",   "B1F A",   "B2A A",
  "B2F A",   "B2I I",   "B2V V",   "BAL A",   "BCS C",   "BFD D",
  "BHD D",   "BLE L",   "BLY K",   "BNN F",   "BNO L",   "BTA L",
  "BTC C",   "BTR W",   "BUC C",   "BUG L",   "C5C C",   "C6C C",
  "CAF C",   "CAS C",   "CAY C",   "CCS C",   "CEA C",   "CGU E",
  "CHG G",   "CHP G",   "CLB A",   "CLD A",   "CLE L",   "CME C",
  "CMT C",   "CSB C",   "CSD A",   "CSE C",   "CSO C",   "CSP C",
  "CSR C",   "CSS C",   "CSW C",   "CSX C",   "CSY C",   "CSZ C",
  "CTH T",   "CXM M",   "CY1 C",   "CYM C",   "CZZ C",   "DAH F",
  "DAL A",   "DAM A",   "DAR R",   "DAS D",   "DBY Y",   "DCY C",
  "DGL E",   "DGN Q",   "DHI H",   "DHN V",   "DIL I",   "DIV V",
  "DLE L",   "DLY K",   "DNP A",   "DOH D",   "DPH F",   "DPN F",
  "DPR P",   "DSE S",   "DSN S",   "DSP D",   "DTH T",   "DTR W",
  "DTY Y",   "DVA V",   "EFC C",   "EHP F",   "EYS C",   "FLA A",
  "FLE L",   "FME M",   "FTY Y",   "GGL E",   "GHP G",   "GSC G",
  "GT9 C",   "H5M P",   "HAC A",   "HAR R",   "HIC H",   "HIP H",
  "HMR R",   "HPH F",   "HPQ F",   "HTR W",   "HV5 A",   "HYP P",
  "IAS N",   "IIL I",   "ILG Q",   "IML I",   "IN2 K",   "ISO A",
  "IVA V",   "IYR Y",   "KCX K",   "KPH K",   "LLY K",   "LOL L",
  "LPL L",   "LTR W",   "LYM K",   "LYZ K",   "M3L K",   "MAA A",
  "MAI R",   "MEN N",   "MGN Q",   "MGY G",   "MHL L",   "MHO M",
  "MHS H",   "MIS S",   "MLE L",   "MLY K",   "MLZ K",   "MME M",
  "MNL L",   "MNV V",   "MPQ G",   "MSE M",   "MSO M",   "MTY Y",
  "MVA V",   "NAL A",   "NAM A",   "NCY C",   "NEM H",   "NEP H",
  "NFA F",   "NIT A",   "NLE L",   "NLN L",   "NNH R",   "NPH C",
  "NVA V",   "OAS S",   "OCS C",   "OCY C",   "OMT M",   "OPR R",
  "PAQ F",   "PBB C",   "PCA E",   "PEC C",   "PGY G",   "PHA F",
  "PHD N",   "PHI F",   "PHL F",   "PHM F",   "PLE L",   "POM P",
  "PPH F",   "PPN F",   "PR3 C",   "PRR A",   "PRS P",   "PTH Y",
  "PTR Y",   "PYA A",   "RON V",   "S1H S",   "SAC S",   "SAH C",
  "SAM M",   "SBD A",   "SBL A",   "SCH C",   "SCS C",   "SCY C",
  "SEB S",   "SEG A",   "SEP S",   "SET S",   "SHC C",   "SHP G",
  "SLZ K",   "SMC C",   "SME M",   "SNC C",   "SOC C",   "STY Y",
  "SVA S",   "TBG G",   "TCR W",   "THC T",   "THO T",   "TIH A",
  "TNB C",   "TPL W",   "TPO T",   "TPQ F",   "TRF W",   "TRG K",
  "TRN W",   "TRO W",   "TYB Y",   "TYI Y",   "TYN Y",   "TYQ Y",
  "TYS Y",   "TYY A",   "VAD V",   "VAF V",   "YOF Y",   "  A A",
  "  C C",   "  G G",   "  T T",   "  U U"  };
    
  for (i=0 ; i<272 ; i++)  {
  	if (!strncmp(ResCode[i], name , 3))  {
		return (ResCode[i][4]) ;
  	}
  }
  return ('\0') ;
}
