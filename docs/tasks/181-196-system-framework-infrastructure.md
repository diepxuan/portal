# Task 181-196: System-DLLs

## Nhom: System (Framework & Infrastructure)

## Muc tieu
Ghi nhan cau truc cac System DLLs - day la cac thu vien framework/infrastructure, khong can chuyen doi ngay.

## Chi tiet chung
- **Nhom DLL:** AsiaLicenseCommon, DashBoard, Docking, DynReport, DynamicReport, Framework, GenerationReport, Helper, OptFieldInfo, OptFieldSetup, ReportDynamic, RptCommon, SMFFY, SMKS, SMUserInfo, ToolCommon
- **Loai:** System/Framework DLLs
- **Assembly Company:** Asia Software Development JSC / ASIASOFT
- **Ma_ct:** SYSTEM

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/*.dll/README.md`

---

## 1. AsiaLicenseCommon.dll (Quan ly License)

| Thuoc tinh | Gia tri |
|------------|---------|
| Assembly Title | AsiaLicenseCommon |
| Version | 1.0.0.0 |
| Namespace | AsiaLicenseCommon |

### Classes

| Class | Mo ta |
|-------|-------|
| RSA | Validation license bang DSA signature |
| LicenseTerms | Data model thong tin license |
| AsiaSoftLicense | Container cho license |
| Serializer | XML serialization helper |

### Chuc nang
- Quan ly license cho phan mem Simba
- DSA signature validation
- Trial mode 90 ngay

---

## 2. DashBoard.dll (Dashboard Widget System)

| Thuoc tinh | Gia tri |
|------------|---------|
| Assembly Title | DashBoard |
| Version | 1.0.0.0 |
| Namespace | AsiaErp.Docking, AsiaErp.DataAccess |

### Classes

| Class | Mo ta |
|-------|-------|
| frmDashBoard | Main Dashboard container |
| frmDashlet | Widget control |
| DashBoardDAO | Data access |
| asPanel, asFlowPanel | Custom controls |

### Chuc nang
- Dashboard Widget System
- Dashlet types: MENU, TABLE, CHART
- Drag-drop, resize dashlets

---

## 3. Docking.dll (Docking Framework)

| Thuoc tinh | Gia tri |
|------------|---------|
| Assembly Title | Docking |
| Version | 1.1.3.0 |
| Namespace | AsiaErp.Framework.Docking |

### Classes

| Class | Mo ta |
|-------|-------|
| DockPanel | Main container |
| DockContent | Dockable content base |
| DockPane | Pane container |
| DockState | Dock state enum |

### Chuc nang
- Docking framework cho Windows Forms
- VS2005 style docking
- Auto-hide functionality

---

## 4. DynReport.dll (Crystal Report Wrapper)

| Thuoc tinh | Gia tri |
|------------|---------|
| Assembly Title | DynGlRptBCTC01 |
| Version | 1.0.0.0 |
| Namespace | AsiaErp.UserInterface |

### Classes

| Class | Mo ta |
|-------|-------|
| DynCrystalReport | Crystal Report wrapper |
| MyDataSet | DataSet cho report |

### Chuc nang
- Wrapper cho Crystal Reports
- Dynamic column mapping

---

## 5. DynamicReport.dll (Dynamic Report Form)

| Thuoc tinh | Gia tri |
|------------|---------|
| Assembly Title | Bảng kê đơn đặt hàng |
| Version | 1.0.0.0 |
| Namespace | AsiaErp.UserInterface |

### Classes

| Class | Mo ta |
|-------|-------|
| frmDynamicReport | Dynamic report form |
| DynamicReportDAO | Data access |

### Chuc nang
- Tao controls dong tu SP parameters
- Ho tro: TextBox, Lookup, DropDown, CheckBox, DateTime, Radio

---

## 6. Framework.dll (Core Framework)

| Thuoc tinh | Gia tri |
|------------|---------|
| Assembly Title | Framework |
| Version | 1.0.0.0 |
| Namespace | AsiaErp.Framework, AsiaErp.DataAccess |

### Base Classes

| Class | Mo ta |
|-------|-------|
| frmAsiaRoot | Base form cho tat ca forms |
| frmVoucher | Base form cho chung tu |
| frmDMView, frmDMEdit | Base form danh muc |
| frmReport | Base form bao cao |
| frmCalc | Base form tinh toan |

### Custom Controls (As*)

| Control | Mo ta |
|--------|-------|
| AsTextBox | TextBox voi validation |
| AsTextNumeric | TextBox nhap so |
| AsDataGridView | DataGridView mo rong |
| AsComboBox | ComboBox mo rong |

### DAO Pattern

| Interface | Mo ta |
|---------|-------|
| BaseDictionaryDAO | DAO danh muc |
| BaseVoucherDAO | DAO chung tu |
| BaseReportDAO | DAO bao cao |

### Chuc nang
- Core framework cho toan bo he thong
- Base classes, controls, DAOs
- ~81,600 dong code

---

## 7. GenerationReport.dll (RDL Generator)

| Thuoc tinh | Gia tri |
|------------|---------|
| Assembly Title | GenerationReport |
| Version | 1.0.0.0 |
| Namespace | GenerationReport |

### Classes

| Class | Mo ta |
|-------|-------|
| CreateReport | Tao bao cao tu DataGridView |
| RdlGenerator | Tao RDL XML |
| ReportConfig | Cau hinh font, margin |

### Chuc nang
- Tao bao cao RDL (Report Definition Language)
- Xu ly DataGridView -> RDL

---

## 8. Helper.dll (Utility Library)

| Thuoc tinh | Gia tri |
|------------|---------|
| Assembly Title | Utility |
| Version | 1.0.0.0 |
| Namespace | AsiaErp.Framework |

### Classes

| Class | Mo ta |
|-------|-------|
| Helper | Ma hoa, hashing, utilities |
| CBO | Custom Business Object mapping |
| CMessageBox | MessageBox tieng Viet |
| Null | Null value handling |

### Chuc nang
- Ma hoa (RSA, DES, SHA, MD5)
- CBO pattern mapping
- MessageBox localization
- Logging

---

## 9. OptFieldInfo.dll (Truong tu do - Info)

| Thuoc tinh | Gia tri |
|------------|---------|
| Assembly Title | Danh muc cac truong tu do |
| Version | 1.0.0.0 |
| Namespace | AsiaErp.UserInterface |

### Classes

| Class | Mo ta |
|-------|-------|
| frmOptFieldInfo | Form quan ly truong tu do |
| OptFieldDAO | Data access |

### Chuc nang
- Quan ly danh muc truong tu do
- Chinh sua tieu de (caption)

---

## 10. OptFieldSetup.dll (Truong tu do - Setup)

| Thuoc tinh | Gia tri |
|------------|---------|
| Assembly Title | Khai bao truong tu do cho chung tu |
| Version | 1.0.0.0 |
| Namespace | AsiaErp.UserInterface |

### Classes

| Class | Mo ta |
|-------|-------|
| frmOptFieldSetup | Form khai bao truong tu do |
| FieldSetupDAO | Data access |

### Chuc nang
- Khai bao truong tu do cho tung loai chung tu
- Cau hinh Master/Detail display

---

## 11. ReportDynamic.dll (Dynamic Report Form)

| Thuoc tinh | Gia tri |
|------------|---------|
| Assembly Title | Bảng kê đơn đặt hàng |
| Version | 1.0.0.0 |
| Namespace | AsiaErp.UserInterface |

### Classes

| Class | Mo ta |
|-------|-------|
| frmReportDynamic | Form bao cao dong |
| ReportDynamicDAO | Data access |

### Chuc nang
- Tao filter control dong tu string config
- Format: `Field:L=Label:D=Default:T=Type:*`

---

## 12. RptCommon.dll (Common Report)

| Thuoc tinh | Gia tri |
|------------|---------|
| Assembly Title | bảng kê đơn đặt hàng |
| Version | 1.0.0.0 |
| Namespace | AsiaErp.UserInterface |

### Classes

| Class | Mo ta |
|-------|-------|
| frmRptCommon | Form bao cao chung |
| Form1, Form2, Form3 | Forms phu |

### Chuc nang
- Common report framework
- Dynamic filter theo cau hinh menu

---

## 13. SMFFY.dll (Khoa so lieu cuoi nam)

| Thuoc tinh | Gia tri |
|------------|---------|
| Assembly Title | Khoa so lieu |
| Version | 1.0.0.0 |
| Namespace | AsiaERP.UserInterface |

### Classes

| Class | Mo ta |
|-------|-------|
| frmSMFFY | Form khoa so lieu cuoi nam |
| SMFFYDAO | Data access |

### Chuc nang
- Khoa so lieu cuoi nam tai chinh
- Thiet lap ngay dau nam

---

## 14. SMKS.dll (Khoa so lieu)

| Thuoc tinh | Gia tri |
|------------|---------|
| Assembly Title | Khoa so lieu |
| Version | 1.0.0.0 |
| Namespace | AsiaERP.UserInterface |

### Classes

| Class | Mo ta |
|-------|-------|
| frmSMKS | Form khoa so lieu |
| SMKSDAO | Data access |

### Chuc nang
- Khoa so lieu ky tai chinh
- Update ngay khoa so (assiUpd_ks)

---

## 15. SMUserInfo.dll (Quan ly nguoi dung)

| Thuoc tinh | Gia tri |
|------------|---------|
| Assembly Title | Quan ly nguoi dung |
| Version | 1.0.0.0 |
| Namespace | AsiaErp.UserInterface |

### Classes

| Class | Mo ta |
|-------|-------|
| frmSMUserInfo | Form danh sach nguoi dung |
| frmSMUserInfoEdit | Form them/sua nguoi dung |
| frmSmSetRights | Form phan quyen |
| SMUserInfoController | Business logic |
| UserInfo | Entity class |

### Chuc nang
- Quan ly tai khoan nguoi dung
- Phan quyen chuc nang (View/Insert/Update/Delete)
- Phan quyen cong ty
- Doi mat khau, reset mat khau

---

## 16. ToolCommon.dll (Tool Utility)

| Thuoc tinh | Gia tri |
|------------|---------|
| Assembly Title | ToolCommons |
| Version | 1.0.0.0 |
| Namespace | AsiaErp.ToolCommon |

### Classes

| Class | Mo ta |
|-------|-------|
| TCommon | Module tien ich chinh |

### Chuc nang
- Quan ly ket noi database
- Session management
- Helper functions

---

## Dependencies giua cac System DLLs

```
Framework.dll
    ├── Docking.dll (dockable windows)
    ├── Helper.dll (utilities)
    └── AsiaLicenseCommon.dll (license check)

DashBoard.dll
    ├── Docking.dll
    └── Framework.dll

ReportDynamic.dll / RptCommon.dll
    └── Framework.dll

DynReport.dll / GenerationReport.dll
    └── Framework.dll

SMUserInfo.dll / SMKS.dll / SMFFY.dll
    ├── Framework.dll
    └── Helper.dll
```

---

## Muc dich su dung

### Khong can implement ngay
Day la **framework libraries** - cac DLLs nay cung cap:
1. Base classes cho UI
2. Custom controls
3. Infrastructure services
4. Utility functions

### Khi nao can implement?
1. Khi tao cac module business (AR, AP, CA, CO...)
2. Khi can custom controls
3. Khi can tich hop he thong

### Tien do cua Portal Project

| Task | Trang thai | Ghi chu |
|------|----------|---------|
| 181 | Ghi nhan | Khong implement |
| 182 | Ghi nhan | Khong implement |
| ... | ... | ... |
| 196 | Ghi nhan | Khong implement |

---

## Progress Checklist (Documentation only)

- [ ] Ghi nhan cau truc AsiaLicenseCommon
- [ ] Ghi nhan cau truc DashBoard
- [ ] Ghi nhan cau truc Docking
- [ ] Ghi nhan cau truc DynReport
- [ ] Ghi nhan cau truc DynamicReport
- [ ] Ghi nhan cau truc Framework
- [ ] Ghi nhan cau truc GenerationReport
- [ ] Ghi nhan cau truc Helper
- [ ] Ghi nhan cau truc OptFieldInfo
- [ ] Ghi nhan cau truc OptFieldSetup
- [ ] Ghi nhan cau truc ReportDynamic
- [ ] Ghi nhan cau truc RptCommon
- [ ] Ghi nhan cau truc SMFFY
- [ ] Ghi nhan cau truc SMKS
- [ ] Ghi nhan cau truc SMUserInfo
- [ ] Ghi nhan cau truc ToolCommon