ALTER TABLE `admin_company_operators`
  ADD CONSTRAINT `admin_company_operators_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `admin_companys` (`company_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `admin_company_operators_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `admin_roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE
