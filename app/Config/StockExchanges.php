<?php

namespace Config;

class StockExchanges
{
    const EXCHANGES = [
        'HOSE', 'HNX', 'UPCOME'
    ];

    const STOCK_EXCHANGES = [
        'HOSE' => [
            'AAA','AAM','AAT','ABS','ACB','ACC','ACL','ADG','ADS','AGG','AGM','AGR','AMD',
            'ANV','APC','APG','APH','ASM','ASP','AST','BCE','BCG','BCM','BFC','BHN','BIC',
            'BID','BKG','BMC','BMI','BMP','BRC','BTP','BTT','BVH','BWE','C32','C47','CCI',
            'CCL','CDC','CEE','CHP','CIG','CII','CKG','CLC','CLL','CLW','CMG','CMV','CMX',
            'CNG','COM','CRC','CRE','CSM','CSV','CTD','CTF','CTG','CTI','CTS','CVT','D2D',
            'DAG','DAH','DAT','DBC','DBD','DBT','DC4','DCL','DCM','DGC','DGW','DHA','DHC',
            'DHG','DHM','DIG','DLG','DMC','DPG','DPM','DPR','DQC','DRC','DRH','DRL','DSN',
            'DTA','DTL','DTT','DVP','DXG','DXV','EIB','ELC','EMC','EVE','EVG','FCM','FCN',
            'FDC','FIR','FIT','FLC','FMC','FPT','FRT','FTM','FTS','GAB','GAS','GDT','GEG',
            'GEX','GIL','GMC','GMD','GSP','GTA','GTN','GVR','HAG','HAH','HAI','HAP','HAR',
            'HAS','HAX','HBC','HCD','HCM','HDB','HDC','HDG','HHP','HHS','HID','HII','HMC',
            'HNG','HOT','HPG','HPX','HQC','HRC','HSG','HSL','HT1','HTI','HTL','HTN','HTV',
            'HU1','HU3','HUB','HVH','HVN','HVX','IBC','ICT','IDI','IJC','ILB','IMP','ITA',
            'ITC','ITD','JVC','KBC','KDC','KDH','KHP','KMR','KOS','KPF','KSB','L10','LBM',
            'LCG','LCM','LDG','LEC','LGC','LGL','LHG','LIX','LM8','LPB','LSS','MBB','MCG',
            'MCP','MDG','MHC','MIG','MSB','MSH','MSN','MWG','NAF','NAV','NBB','NCT','NHA',
            'NHH','NKG','NLG','NNC','NT2','NTL','NVL','NVT','OCB','OGC','OPC','PAC','PC1',
            'PDN','PDR','PET','PGC','PGD','PGI','PHC','PHR','PIT','PJT','PLP','PLX','PME',
            'PMG','PNC','PNJ','POM','POW','PPC','PSH','PTB','PTC','PTL','PVD','PVT','PXI',
            'PXS','QCG','RAL','RDP','REE','RIC','ROS','S4A','SAB','SAM','SAV','SBA','SBT',
            'SBV','SC5','SCD','SCR','SCS','SFC','SFG','SFI','SGN','SGR','SGT','SHA','SHI',
            'SHP','SII','SJD','SJF','SJS','SKG','SMA','SMB','SMC','SPM','SRC','SRF','SSB',
            'SSI','ST8','STB','STG','STK','SVC','SVD','SVI','SVT','SZC','SZL','TAC','TBC',
            'TCB','TCD','TCH','TCL','TCM','TCO','TCR','TCT','TDC','TDG','TDH','TDM','TDP',
            'TDW','TEG','TGG','THG','TIP','TIX','TLD','TLG','TLH','TMP','TMS','TMT','TN1',
            'TNA','TNC','TNH','TNI','TNT','TPB','TPC','TRA','TRC','TS4','TSC','TTA','TTB',
            'TTE','TTF','TV2','TVS','TVT','TYA','UDC','UIC','VAF','VCA','VCB','VCF','VCG',
            'VCI','VDP','VDS','VGC','VHC','VHM','VIB','VIC','VID','VIP','VIS','VIX','VJC',
            'VMD','VNE','VNG','VNL','VNM','VNS','VOS','VPB','VPD','VPG','VPH','VPI','VPS',
            'VRC','VRE','VSC','VSH','VSI','VTB','VTO','YBM','YEG'],
        'HNX' => [
            'AAV','ABT','ACM','ADC','ALT','AMC','AME','AMV','API','APP','APS','ARM','ART',
            'ASG','ATS','BAB','BAX','BBC','BBS','BCC','BCF','BDB','BED','BII','BKC','BLF',
            'BNA','BPC','BSC','BSI','BST','BTS','BTW','BVS','BXH','C69','C92','CAG','CAN',
            'CAP','CAV','CDN','CEO','CET','CIA','CJC','CKV','CLH','CLM','CMC','CMS','CPC','CSC','CTB','CTC','CTP','CTT','CTX','CVN','CX8','D11','DAD','DAE','DC2','DDG','DHP','DHT','DIH','DL1','DNC','DNM','DNP','DP3','DPC','DPS','DS3','DST','DTD','DTK','DVG','DXP','DZM','EBA','EBS','ECI','EID','EVS','FDT','FID','GDW','GIC','GKM','GLT','GMA','GMX','HAD','HAT','HBE','HBS','HCC','HCT','HDA','HEV','HGM','HHC','HHG','HJS','HKB','HKT','HLC','HLD','HMH','HOM','HPM','HST','HTC','HTP','HUT','HVT','ICG','IDC','IDJ','IDV','INC','INN','ITQ','IVS','KDM','KHS','KKC','KLF','KMT','KSD','KSQ','KST','KTS','KTT','KVC','L14','L18','L35','L40','L43','L61','L62','LAF','LAS','LBE','LCD','LCS','LDP','LHC','LIG','LM7','LUT','MAC','MAS','MBG','MBS','MCC','MCF','MCO','MDC','MED','MEL','MHL','MIM','MKV','MSC','MST','MVB','NAG','NAP','NBC','NBP','NBW','NDN','NDX','NET','NFC','NHC','NHP','NRC','NSC','NSH','NST','NTH','NTP','NVB','OCH','ONE','PAN','PBP','PCE','PCG','PCT','PDB','PDC','PEN','PGN','PGS','PGT','PHN','PHP','PIA','PIC','PJC','PLC','PMB','PMC','PMP','PMS','POT','PPE','PPP','PPS','PPY','PRC','PRE','PSC','PSD','PSE','PSI','PSW','PTD','PTI','PTS','PV2','PVB','PVC','PVG','PVI','PVL','PVS','QBS','QHD','QST','QTC','RCL','S55','S99','SAF','SCI','SD2','SD4','SD5','SD6','SD9','SDA','SDC','SDG','SDN','SDT','SDU','SEB','SED','SFN','SGC','SGD','SGH','SHB','SHE','SHN','SHS','SIC','SJ1','SJC','SJE','SLS','SMN','SMT','SPI','SRA','SSC','SSM','STC','STP','SVN','SZB','TA9','TAR','TBX','TC6','TDN','TDT','TET','TFC','THB','THD','THI','THS','THT','TIG','TJC','TKC','TKU','TMB','TMC','TMX','TNG','TPH','TPP','TSB','TST','TTC','TTH','TTL','TTT','TTZ','TV3','TV4','TVB','TVC','TVD','TXM','UNI','V12','V21','VAT','VBC','VC1','VC2','VC3','VC6','VC7','VC9','VCC','VCM','VCS','VDL','VE1','VE2','VE3','VE4','VE8','VFG','VGP','VGS','VHE','VHL','VIE','VIF','VIG','VIT','VKC','VLA','VMC','VMI','VMS','VNC','VND','VNF','VNR','VNT','VSA','VSM','VTC','VTH','VTJ','VTL','VTV','VXB','WCS','WSS','X20'],
        'UPCOME' => [
            'A32','AAS','ABB','ABC','ABI','ABR','ACE','ACS','ACV','ADP','AFC','AFX','AG1',
            'AGF','AGP','AGX','AIC','ALV','AMP','AMS','ANT','APF','APL','APT','AQN','ASA',
            'ASD','ATA','ATB','ATD','ATG','AUM','AVC','AVF','B82','BAL','BBH','BBM','BBT',
            'BCB','BCP','BCV','BDC','BDF','BDG','BDP','BDT','BDW','BEL','BGW','BHA','BHC',
            'BHG','BHK','BHP','BHT','BHV','BIO','BKH','BLI','BLN','BLT','BLU','BLW','BM9',
            'BMD','BMF','BMG','BMJ','BMN','BMS','BMV','BNW','BOT','BPW','BQB','BRR','BRS',
            'BSA','BSD','BSG','BSH','BSL','BSP','BSQ','BSR','BT1','BT6','BTB','BTC','BTD','BTG','BTH','BTN','BTR','BTU','BTV','BUD','BVB','BVG','BVL','BVN','BWA','BWS','BXT','C12','C21','C22','C36','C4G','C71','CAB','CAD','CAM','CAT','CBC','CBI','CBS','CC1','CC4','CCA','CCH','CCM','CCP','CCR','CCT','CCV','CDG','CDH','CDO','CDP','CDR','CE1','CEC','CEG','CEN','CFC','CFM','CFV','CGL','CGV','CH5','CHC','CHS','CI5','CID','CIP','CKA','CKD','CLG','CLX','CMD','CMF','CMI','CMK','CMN','CMP','CMT','CMW','CNC','CNN','CNT','CPA','CPH','CPI','CPW','CQN','CQT','CSI','CST','CT3','CT5','CT6','CTA','CTN','CTR','CTW','CVC','CVH','CXH','CYC','DAC','DAP','DAR','DAS','DBH','DBM','DBW','DC1','DCF','DCG','DCH','DCI','DCR','DCS','DCT','DDH','DDM','DDN','DDV','DFC','DFS','DGT','DHB','DHD','DHN','DIC','DID','DKC','DKH','DKP','DLD','DLR','DLT','DM7','DNA','DNB','DND','DNE','DNH','DNL','DNN','DNR','DNS','DNT','DNW','DNY','DOC','DOP','DP1','DP2','DPD','DPH','DPP','DRG','DRI','DSC','DSG','DSP','DSS','DSV','DT4','DTB','DTC','DTE','DTG','DTI','DTP','DTV','DUS','DVC','DVN','DVW','DWS','DX2','DXD','DXL','E12','E29','EAD','EFI','EIC','EIN','EME','EMG','EMS','EPC','EPH','EVF','FBA','FBC','FCC','FCS','FDG','FGL','FHN','FHS','FIC','FOC','FOX','FRC','FRM','FSO','FT1','FTI','G20','G36','GCB','GE2','GER','GGG','GGS','GHC','GLC','GLW','GND','GQN','GSM','GTC','GTD','GTH','GTK','GTS','GTT','GVT','H11','HAB','HAC','HAF','HAM','HAN','HAV','HAW','HBD','HBH','HBW','HC1','HC3','HCB','HCI','HCS','HD2','HD6','HD8','HDM','HDO','HDP','HDW','HEC','HEJ','HEM','HEP','HES','HFB','HFC','HFS','HFX','HGA','HGC','HGR','HGT','HGW','HHN','HHR','HHV','HIG','HIZ','HJC','HKC','HKP','HLA','HLB','HLE','HLG','HLR','HLS','HLT','HLY','HMG','HMS','HNA','HNB','HND','HNE','HNF','HNI','HNM','HNP','HNR','HNT','HPB','HPD','HPH','HPI','HPP','HPT','HPU','HPW','HRB','HRT','HSA','HSI','HSM','HSP','HSV','HTE','HTG','HTK','HTM','HTR','HTT','HTU','HTW','HU4','HU6','HUG','HUX','HVA','HVG','HWS','I10','IBD','IBN','ICC','ICF','ICI','ICN','IDP','IFC','IFS','IHK','IKH','ILA','ILC','ILS','IME','IN4','IPA','IPH','IRC','ISG','ISH','IST','ITS','JOS','KAC','KBE','KCB','KCE','KGM','KHA','KHB','KHD','KHL','KHW','KIP','KLB','KLM','KSE','KSH','KSK','KSV','KTB','KTC','KTL','L12','L44','L45','L63','LAI','LAW','LBC','LCC','LCW','LDW','LG9','LGM','LIC','LKW','LLM','LM3','LMC','LMH','LMI','LNC','LO5','LPT','LQN','LTC','LTG','LWS','LYF','M10','MA1','MAI','MBN','MC3','MCH','MCI','MCM','MCT','MDA','MDF','MDT','MEC','MEF','MEG','MES','MFS','MGC','MGG','MH3','MHP','MHY','MIC','MIE','MKP','MLC','MLS','MML','MNB','MND','MPC','MPT','MPY','MQB','MQN','MRF','MSR','MTA','MTB','MTC','MTG','MTH','MTL','MTM','MTP','MTS','MTV','MVC','MVN','MVY','MXC','NAB','NAC','NAS','NAU','NAW','NBE','NBR','NBT','NCP','NCS','ND2','NDC','NDF','NDP','NDT','NDW','NED','NGC','NHT','NHV','NJC','NLS','NMK','NNB','NNG','NNQ','NNT','NOS','NPH','NQB','NQN','NQT','NS2','NS3','NSG','NSL','NSS','NTB','NTC','NTF','NTR','NTT','NTW','NUE','NVP','NWT','OIL','ONW','ORS','PAI','PAS','PBC','PBK','PBT','PCC','PCF','PCM','PCN','PDT','PDV','PEC','PEG','PEQ','PFL','PGB','PGV','PHH','PHS','PID','PIS','PIV','PJS','PKR','PLA','PLE','PLO','PMJ','PMT','PMW','PND','PNG','PNP','PNT','POB','POS','POV','PPH','PPI','PQN','PRO','PRT','PSB','PSG','PSL','PSN','PSP','PTE','PTG','PTH','PTK','PTO','PTP','PTT','PTV','PTX','PVA','PVE','PVH','PVM','PVO','PVP','PVR','PVV','PVX','PVY','PWA','PWS','PX1','PXA','PXC','PXL','PXM','PXT','PYU','QBR','QCC','QHW','QLD','QLT','QNC','QNS','QNT','QNU','QNW','QPH','QSP','QTP','RAT','RBC','RCC','RCD','RGC','RHN','RLC','RTB','RTH','RTS','S12','S27','S72','S74','S96','SAC','SAL','SAP','SAS','SB1','SBD','SBH','SBL','SBM','SBR','SBS','SCA','SCC','SCG','SCJ','SCL','SCO','SCV','SCY','SD1','SD3','SD7','SD8','SDB','SDD','SDE','SDH','SDJ','SDK','SDP','SDV','SDX','SDY','SEA','SEP','SGB','SGO','SGP','SGS','SHC','SHG','SHX','SID','SIG','SIP','SIV','SJG','SJM','SKH','SKN','SKV','SNC','SNZ','SON','SOV','SP2','SPA','SPB','SPC','SPD','SPH','SPP','SPV','SQC','SRB','SRT','SSF','SSG','SSN','SSU','STH','STL','STS','STT','STU','STV','STW','SUM','SVG','SVH','SVL','SWC','SZE','T12','TA3','TA6','TAG','TAN','TAP','TAW','TB8','TBD','TBT','TCI','TCJ','TCK','TCW','TDB','TDF','TDS','TEC','TEL','TGP','TH1','THN','THP','THR','THU','THW','TID','TIE','TIS','TKA','TKG','TL4','TLI','TLP','TLT','TMG','TMW','TNB','TNM','TNP','TNS','TNW','TOP','TOT','TOW','TPS','TQN','TQW','TR1','TRS','TRT','TS3','TS5','TSD','TSG','TSJ','TTD','TTG','TTJ','TTN','TTP','TTS','TTV','TUG','TV1','TV6','TVA','TVG','TVH','TVM','TVN','TVP','TVU','TVW','TW3','UCT','UDJ','UDL','UEM','UMC','UPC','UPH','USC','USD','V11','V15','VAV','VBB','VBG','VBH','VC5','VCE','VCP','VCR','VCT','VCW','VCX','VDB','VDM','VDN','VDT','VE9','VEA','VEC','VEE','VEF','VES','VET','VFC','VFR','VFS','VGG','VGI','VGL','VGR','VGT','VGV','VHD','VHF','VHG','VHH','VHI','VIH','VIM','VIN','VIR','VIW','VKD','VKP','VLB','VLC','VLF','VLG','VLP','VLW','VMA','VMG','VNA','VNB','VNH','VNI','VNP','VNX','VNY','VOC','VPA','VPC','VPK','VPR','VPW','VQC','VRG','VSE','VSF','VSG','VSN','VSP','VST','VT1','VTA','VTD','VTE','VTG','VTI','VTK','VTM','VTP','VTQ','VTR','VTS','VTX','VVN','VW3','VWS','VXP','VXT','WSB','WTC','WTN','X18','X26','X77','XDH','XHC','XLV','XMC','XMD','XPH','YBC','YRC','YTC']
    ];

    const NO_DATA_STOCKS = [
        'A32','AAS','ABB','ABC','ABI','ABR','ACE','ACS','ACV','ADP','AFC','AFX','AG1','AGF','AGP','AGX','AIC','ALV','AMP','AMS','ANT','APF','APL','APT','AQN','ASA','ASD','ATA','ATB','ATD','ATG','AUM','AVC','AVF','B82','BAL','BBH','BBM','BBT','BCB','BCP','BCV','BDC','BDF','BDG','BDP','BDT','BDW','BEL','BGW','BHA','BHC','BHG','BHK','BHP','BHT','BHV','BIO','BKH','BLI','BLN','BLT','BLU','BLW','BM9','BMD','BMF','BMG','BMJ','BMN','BMS','BMV','BNW','BOT','BPW','BQB','BRR','BRS','BSA','BSD','BSG','BSH','BSL','BSP','BSQ','BT1','BT6','BTB','BTC','BTD','BTG','BTH','BTN','BTR','BTU','BTV','BUD','BVB','BVG','BVL','BVN','BWA','BWS','BXT','C12','C21','C22','C36','C4G','C71','CAB','CAD','CAM','CAT','CBC','CBI','CBS','CC1','CC4','CCA','CCH','CCM','CCP','CCR','CCT','CCV','CDG','CDH','CDO','CDP','CDR','CE1','CEC','CEG','CEN','CFC','CFM','CFV','CGL','CGV','CH5','CHC','CHS','CI5','CID','CIP','CKA','CKD','CLG','CLX','CMD','CMF','CMI','CMK','CMN','CMP','CMT','CMW','CNC','CNN','CNT','CPA','CPH','CPI','CPW','CQN','CQT','CSI','CST','CT3','CT5','CT6','CTA','CTN','CTR','CTW','CVC','CVH','CXH','CYC','DAC','DAP','DAR','DAS','DBH','DBM','DBW','DC1','DCF','DCG','DCH','DCI','DCR','DCS','DCT','DDH','DDM','DDN','DDV','DFC','DFS','DGT','DHB','DHD','DHN','DIC','DID','DKC','DKH','DKP','DLD','DLR','DLT','DM7','DNA','DNB','DND','DNE','DNH','DNL','DNN','DNR','DNS','DNT','DNW','DNY','DOC','DOP','DP1','DP2','DPD','DPH','DPP','DRG','DRI','DSC','DSG','DSP','DSS','DSV','DT4','DTB','DTC','DTE','DTG','DTI','DTP','DTV','DUS','DVC','DVN','DVW','DWS','DX2','DXD','DXL','E12','E29','EAD','EFI','EIC','EIN','EME','EMG','EMS','EPC','EPH','EVF','FBA','FBC','FCC','FCS','FDG','FGL','FHN','FHS','FIC','FOC','FOX','FRC','FRM','FSO','FT1','FTI','G20','G36','GCB','GE2','GER','GGG','GGS','GHC','GLC','GLW','GND','GQN','GSM','GTC','GTD','GTH','GTK','GTS','GTT','GVT','H11','HAB','HAC','HAF','HAM','HAN','HAV','HAW','HBD','HBH','HBW','HC1','HC3','HCB','HCI','HCS','HD2','HD6','HD8','HDM','HDO','HDP','HDW','HEC','HEJ','HEM','HEP','HES','HFB','HFC','HFS','HFX','HGA','HGC','HGR','HGT','HGW','HHN','HHR','HHV','HIG','HIZ','HJC','HKC','HKP','HLA','HLB','HLE','HLG','HLR','HLS','HLT','HLY','HMG','HMS','HNA','HNB','HND','HNE','HNF','HNI','HNM','HNP','HNR','HNT','HPB','HPD','HPH','HPI','HPP','HPT','HPU','HPW','HRB','HRT','HSA','HSI','HSM','HSP','HSV','HTE','HTG','HTK','HTM','HTR','HTT','HTU','HTW','HU4','HU6','HUG','HUX','HVA','HVG','HWS','I10','IBD','IBN','ICC','ICF','ICI','ICN','IDP','IFC','IFS','IHK','IKH','ILA','ILC','ILS','IME','IN4','IPA','IPH','IRC','ISG','ISH','IST','ITS','JOS','KAC','KBE','KCB','KCE','KGM','KHA','KHB','KHD','KHL','KHW','KIP','KLB','KLM','KSE','KSH','KSK','KSV','KTB','KTC','KTL','L12','L44','L45','L63','LAI','LAW','LBC','LCC','LCW','LDW','LG9','LGM','LIC','LKW','LLM','LM3','LMC','LMH','LMI','LNC','LO5','LPT','LQN','LTC','LTG','LWS','LYF','M10','MA1','MAI','MBN','MC3','MCH','MCI','MCM','MCT','MDA','MDF','MDT','MEC','MEF','MEG','MES','MFS','MGC','MGG','MH3','MHP','MHY','MIC','MIE','MKP','MLC','MLS','MML','MNB','MND','MPC','MPT','MPY','MQB','MQN','MRF','MSR','MTA','MTB','MTC','MTG','MTH','MTL','MTM','MTP','MTS','MTV','MVC','MVN','MVY','MXC','NAB','NAC','NAS','NAU','NAW','NBE','NBR','NBT','NCP','NCS','ND2','NDC','NDF','NDP','NDT','NDW','NED','NGC','NHT','NHV','NJC','NLS','NMK','NNB','NNG','NNQ','NNT','NOS','NPH','NQB','NQN','NQT','NS2','NS3','NSG','NSL','NSS','NTB','NTC','NTF','NTR','NTT','NTW','NUE','NVP','NWT','OIL','ONW','ORS','PAI','PAS','PBC','PBK','PBT','PCC','PCF','PCM','PCN','PDT','PDV','PEC','PEG','PEQ','PFL','PGB','PGV','PHH','PHS','PID','PIS','PIV','PJS','PKR','PLA','PLE','PLO','PMJ','PMT','PMW','PND','PNG','PNP','PNT','POB','POS','POV','PPH','PPI','PQN','PRO','PRT','PSB','PSG','PSL','PSN','PSP','PTE','PTG','PTH','PTK','PTO','PTP','PTT','PTV','PTX','PVA','PVE','PVH','PVM','PVO','PVP','PVR','PVV','PVX','PVY','PWA','PWS','PX1','PXA','PXC','PXL','PXM','PXT','PYU','QBR','QCC','QHW','QLD','QLT','QNC','QNS','QNT','QNU','QNW','QPH','QSP','QTP','RAT','RBC','RCC','RCD','RGC','RHN','RLC','RTB','RTH','RTS','S12','S27','S72','S74','S96','SAC','SAL','SAP','SAS','SB1','SBD','SBH','SBL','SBM','SBR','SBS','SCA','SCC','SCG','SCJ','SCL','SCO','SCV','SCY','SD1','SD3','SD7','SD8','SDB','SDD','SDE','SDH','SDJ','SDK','SDP','SDV','SDX','SDY','SEA','SEP','SGB','SGO','SGP','SGS','SHC','SHG','SHX','SID','SIG','SIP','SIV','SJG','SJM','SKH','SKN','SKV','SNC','SNZ','SON','SOV','SP2','SPA','SPB','SPC','SPD','SPH','SPP','SPV','SQC','SRB','SRT','SSF','SSG','SSN','SSU','STH','STL','STS','STT','STU','STV','STW','SUM','SVG','SVH','SVL','SWC','SZE','T12','TA3','TA6','TAG','TAN','TAP','TAW','TB8','TBD','TBT','TCI','TCJ','TCK','TCW','TDB','TDF','TDS','TEC','TEL','TGP','TH1','THN','THP','THR','THU','THW','TID','TIE','TIS','TKA','TKG','TL4','TLI','TLP','TLT','TMG','TMW','TNB','TNM','TNP','TNS','TNW','TOP','TOT','TOW','TPS','TQN','TQW','TR1','TRS','TRT','TS3','TS5','TSD','TSG','TSJ','TTD','TTG','TTJ','TTN','TTP','TTS','TTV','TUG','TV1','TV6','TVA','TVG','TVH','TVM','TVN','TVP','TVU','TVW','TW3','UCT','UDJ','UDL','UEM','UMC','UPC','UPH','USC','USD','V11','V15','VAV','VBB','VBG','VBH','VC5','VCE','VCP','VCR','VCT','VCW','VCX','VDB','VDM','VDN','VDT','VE9','VEA','VEC','VEE','VEF','VES','VET','VFC','VFR','VFS','VGG','VGI','VGL','VGR','VGV','VHD','VHF','VHG','VHH','VHI','VIH','VIM','VIN','VIR','VIW','VKD','VKP','VLB','VLC','VLF','VLG','VLP','VLW','VMA','VMG','VNA','VNB','VNH','VNI','VNP','VNX','VNY','VPA','VPC','VPK','VPR','VPW','VQC','VRG','VSE','VSF','VSG','VSN','VSP','VST','VT1','VTA','VTD','VTE','VTG','VTI','VTK','VTM','VTP','VTQ','VTR','VTS','VTX','VVN','VW3','VWS','VXP','VXT','WSB','WTC','WTN','X18','X26','X77','XDH','XHC','XLV','XMC','XMD','XPH','YBC','YRC','YTC',
        'CLC', 'BHN', 'APC', 'BRC', 'AAM', 'LGC', 'BAX', 'NET',
        'DAE', 'CTP', 'CX8', 'D11', 'DAD', 'DC2', 'DHP', 'DHT', 'DP3', 'CTB', 'C92', 'BST', 
        'CAG', 'CMC', 'CAP', 'CDN', 'CKV', 'BDB', 'HVT', 'ICG', 'HLD', 'KTS', 'HLC', 'GIC', 
        'DZM', 'EBS', 'EVS', 'GMX', 'HAD', 'HCC', 'HJS', 'BCF', 'UIC', 'VAF', 'VCA', 'VDP', 
        'TVT', 'TN1', 'TNC', 'TPC', 'TRA', 'TRC', 'TTE', 'YBM', 'APP', 'ASG', 'BBC', 'VSI', 
        'VMD', 'VNL', 'VPS', 'VRC', 'TMP', 'TJC', 'THI', 'TMB', 'TMX', 'TST', 'TTC', 'SDN', 
        'SDT', 'SED', 'SHE', 'SHN', 'SJ1', 'SZB', 'SLS', 'SMN', 'SSC', 'VIF', 'VMS', 'VNC', 
        'VNF', 'VTJ', 'VTL', 'WCS', 'WSS', 'VFG', 'VC1', 'TXM', 'UNI', 'VBC', 'VE8', 'VC6', 
        'VC9', 'VCC', 'VE1', 'SDG', 'SD9', 'L61', 'NSC', 'NFC', 'NHC', 'NTH', 'PCT', 'LUT', 
        'L62', 'LHC', 'LM7', 'MHL', 'MCF', 'MCO', 'MDC', 'MED', 'MEL', 'QTC', 'SAF', 'SD2', 
        'SD4', 'PTS', 'PDC', 'PMB', 'PGN', 'PGT', 'PIA', 'PMC', 'PMP', 'POT', 'PPP', 'PRC', 
        'TMS', 'FDC', 'GDT', 'DRL', 'DSN', 'EMC', 'DTA', 'DTL', 'DVP', 'DXV', 'HOT', 'HRC', 
        'HTL', 'HTV', 'HU1', 'GTA', 'HAS', 'DMC', 'HUB', 'BMP', 'CCI', 'CHP', 'CVT', 'DHG', 
        'CLL', 'COM', 'HU3', 'SFG', 'SFI', 'SGN', 'SHA', 'SC5', 'SII', 'SCD', 'SMA', 'RIC', 
        'S4A', 'SAV', 'TCT', 'TDP', 'SPM', 'SRC', 'ST8', 'STK', 'SVI', 'SZL', 'LBM', 'LEC', 
        'LIX', 'KPF', 'LM8', 'MCP', 'IMP', 'HVX', 'ILB', 'MDG', 'PGD', 'PGI', 'PIT', 'PJT', 
        'OPC', 'NAV', 'X20', 'VIS', 'GTN', 'TAC', 'HST', 'PME', 'TDW', 'PEN', 'L40', 'HAT',
        'SJE', 'STP', 'PPY', 'SMB', 'NCT', 'VLA', 'TBC', 'RCL', 'HCT', 'HPM', 'KHS', 'AST',
        'DTT', 'GAB', 'L10', 'SFC', 'SVC', 'TIX', 'ACM', 'ADC', 'AMC', 'ARM', 'BED', 'BLF',
        'BSC', 'BTW', 'BXH', 'CJC', 'CTT', 'DPC', 'DPS', 'EBA', 'ECI', 'FDT', 'GDW', 'GMA',
        'HBE', 'HEV', 'HGM', 'HHC', 'HHG', 'HTC', 'INC', 'KKC', 'KST', 'L35', 'LBE', 'LCD',
        'LCS', 'MCC', 'MKV', 'MSC', 'NAP', 'NVB', 'PCG', 'PHN', 'PIC', 'QST', 'SD6', 'SFN',
        'SGC', 'SGD', 'STC', 'TBX', 'TET', 'THB', 'THS', 'TMC', 'TSB', 'VDL', 'VE2', 'VE4',
        'VGP', 'VSM', 'VTC', 'VTH', 'VXB', 'NST', 'VIT', 'L43', 'PXS', 'VNT', 'SSM', 'SEB',
        'PSC', 'MIM', 'KMT', 'CTX'
    ];

    public function getExchanges()
    {
        return self::EXCHANGES;
    }

    public function getStockExchanges()
    {
        $stockExchanges = self::STOCK_EXCHANGES;
        $activedStocks = [];

        foreach ($stockExchanges as $name => $values) {
            $activedStocks[$name] = array_diff($values, self::NO_DATA_STOCKS);
        }

        $results = [];
        foreach ($activedStocks as $name => $values) {
            if (in_array($name, self::getExchanges()) ) {
                $results[$name] = $values;
            }
        }

        return $results;
    }

    public function findExchange(string $code): string
    {
        $stockExchanges = self::STOCK_EXCHANGES;
        foreach ($stockExchanges as $name => $values) {
            if (in_array($code, $values) ) {
                return $name;
            }
        }
    }
}