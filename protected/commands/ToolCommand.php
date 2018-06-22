<?php
/**
 * 缓存管理脚本
 */
class ToolCommand extends CConsoleCommand
{
	public function actionIn()
	{
		$arr = [['title'=>'甲型肝炎抗体（静脉血）','name'=>'甲型肝炎抗体（HAV-Ab）','unit'=>'- +',],
['title'=>'乙型肝炎（静脉血）','name'=>'乙型肝炎病毒表面抗原（HBsAg）','unit'=>'- +',],
['title'=>'乙型肝炎（静脉血）','name'=>'乙型肝炎病毒表面抗体（HBsAb）','unit'=>'- +',],
['title'=>'乙型肝炎（静脉血）','name'=>'乙型肝炎病毒e抗原（HBeAg）','unit'=>'- +',],
['title'=>'乙型肝炎（静脉血）','name'=>'乙型肝炎病毒e抗体（HBeAb）','unit'=>'- +',],
['title'=>'乙型肝炎（静脉血）','name'=>'乙型肝炎病毒核心抗体（HBcAb）','unit'=>'- +',],
['title'=>'乙型肝炎（静脉血）','name'=>'乙型肝炎病毒外膜蛋白S1抗原（Pre-S1Ag）','unit'=>'- +',],
['title'=>'丙型肝炎病毒抗体（静脉血）','name'=>'丙型肝炎抗体（HCV-Ab）','unit'=>'- +',],
['title'=>'戊型肝炎病毒抗体（静脉血）','name'=>'戊型肝炎病毒抗体（HEV-Ab）','unit'=>'- +',],
['title'=>'人类免疫缺陷病毒抗体（静脉血）','name'=>'人类免疫缺陷病毒抗体（HIV-Ab）','unit'=>'- +',],
['title'=>'弓形体抗体测定（静脉血）','name'=>'弓形体抗体','unit'=>'- +',],
['title'=>'风疹病毒抗体（静脉血）','name'=>'风疹病毒抗体','unit'=>'- +',],
['title'=>'巨细胞病毒抗体（静脉血）','name'=>'巨细胞病毒抗体','unit'=>'- +',],
['title'=>'单纯疱疹病毒抗体（静脉血）','name'=>'单纯疱疹病毒抗体','unit'=>'- +',],
['title'=>'幽门螺杆菌抗体（静脉血）','name'=>'lgM','unit'=>'- +',],
['title'=>'幽门螺杆菌抗体（静脉血）','name'=>'lgG','unit'=>'- +',],
['title'=>'25-羟化维生素D测定（静脉血）','name'=>'25-羟化维生素D','unit'=>'nmol/L',],
['title'=>'抗核抗体+滴度监测（静脉血）','name'=>'抗核抗体（ANAs）','unit'=>'- +',],
['title'=>'抗核抗体+滴度监测（静脉血）','name'=>'抗核抗体滴度','unit'=>'＜1:100',],
['title'=>'抗可提取核抗原谱检测（静脉血）','name'=>'抗Sm抗体','unit'=>'- +',],
['title'=>'抗可提取核抗原谱检测（静脉血）','name'=>'抗U1-nRNP抗体','unit'=>'- +',],
['title'=>'抗可提取核抗原谱检测（静脉血）','name'=>'抗SS-A抗体','unit'=>'- +',],
['title'=>'抗可提取核抗原谱检测（静脉血）','name'=>'抗SS-B抗体','unit'=>'- +',],
['title'=>'抗可提取核抗原谱检测（静脉血）','name'=>'抗Scl-70抗体','unit'=>'- +',],
['title'=>'抗可提取核抗原谱检测（静脉血）','name'=>'抗Jo-1抗体','unit'=>'- +',],
['title'=>'抗双链DNA抗体（静脉血）','name'=>'抗双链DNA抗体（Anti-dsDNA）','unit'=>'- +',],
['title'=>'抗心磷脂抗体lgM、lgG（静脉血）','name'=>'抗心磷脂抗体lgM，lgG（ACA-lgM,lgM）','unit'=>'- +',],
['title'=>'抗中性粒细胞胞浆抗体（静脉血）','name'=>'抗中性粒细胞胞浆抗体（ANCA）','unit'=>'- +',],
['title'=>'抗环瓜氨酸肽抗体测定（静脉血）','name'=>'抗环瓜氨酸肽抗体','unit'=>'- +',],
['title'=>'磷酸葡萄糖异构酶测定（静脉血）','name'=>'磷酸葡萄糖异构酶（GPI）','unit'=>'- +',],
];
 foreach ($arr as $key => $value) {
 	$obj = new BasicTagExt;
 	$obj->attributes = $value;
 	$obj->cid = 140;
 	$obj->status = 1;
 	$obj->save();
 }
	}
}