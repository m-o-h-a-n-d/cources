(function () {
  function createToast(message, variant) {
    const container = document.getElementById("toastContainer");
    if (!container) {
      return;
    }

    const toast = document.createElement("div");
    toast.className =
      "toast align-items-center text-bg-" + variant + " border-0 show mb-2";
    toast.setAttribute("role", "alert");
    toast.innerHTML =
      '<div class="d-flex"><div class="toast-body">' +
      message +
      '</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>';
    container.appendChild(toast);

    setTimeout(function () {
      toast.remove();
    }, 3500);
  }

  document.addEventListener("click", function (event) {
    const toastBtn = event.target.closest("[data-toast]");
    if (toastBtn) {
      createToast(
        toastBtn.getAttribute("data-toast"),
        toastBtn.getAttribute("data-variant") || "primary",
      );
    }

    const confirmBtn = event.target.closest("[data-confirm]");
    if (confirmBtn) {
      const target = document.getElementById("confirmModalMessage");
      if (target) {
        target.textContent = confirmBtn.getAttribute("data-confirm");
      }
      const confirmModal = new bootstrap.Modal(
        document.getElementById("confirmModal"),
      );
      confirmModal.show();
    }
  });

  document.querySelectorAll(".image-dropzone").forEach(function (dropzone) {
    const inputSelector = dropzone.getAttribute("data-input");
    const input = inputSelector ? document.querySelector(inputSelector) : null;
    const preview = dropzone.querySelector(".image-preview");

    if (!input || !preview) {
      return;
    }

    const renderPreview = function (file) {
      if (!file) {
        preview.innerHTML =
          '<span class="text-muted-soft small">No image selected</span>';
        return;
      }

      const reader = new FileReader();
      reader.onload = function (e) {
        preview.innerHTML = '<img src="' + e.target.result + '" alt="Preview">';
      };
      reader.readAsDataURL(file);
    };

    const setFile = function (file) {
      if (!file || !file.type.startsWith("image/")) {
        return;
      }

      const dataTransfer = new DataTransfer();
      dataTransfer.items.add(file);
      input.files = dataTransfer.files;
      renderPreview(file);
    };

    dropzone.addEventListener("click", function () {
      input.click();
    });

    dropzone.addEventListener("keydown", function (event) {
      if (event.key === "Enter" || event.key === " ") {
        event.preventDefault();
        input.click();
      }
    });

    dropzone.addEventListener("dragover", function (event) {
      event.preventDefault();
      dropzone.classList.add("dragover");
    });

    dropzone.addEventListener("dragleave", function () {
      dropzone.classList.remove("dragover");
    });

    dropzone.addEventListener("drop", function (event) {
      event.preventDefault();
      dropzone.classList.remove("dragover");
      const file = event.dataTransfer.files && event.dataTransfer.files[0];
      setFile(file);
    });

    input.addEventListener("change", function () {
      const file = input.files && input.files[0];
      renderPreview(file);
    });
  });

  const studentModal = document.getElementById("studentModal");
  if (studentModal) {
    const studentForm = document.getElementById("studentForm");
    const studentModalTitle = document.getElementById("studentModalTitle");
    const studentModalSubmit = document.getElementById("studentModalSubmit");
    const studentRecordId = document.getElementById("studentRecordId");
    const studentCurrentImage = document.getElementById("studentCurrentImage");
    const studentStudentId = document.getElementById("studentStudentId");
    const studentFullName = document.getElementById("studentFullName");
    const studentEmail = document.getElementById("studentEmail");
    const studentAge = document.getElementById("studentAge");
    const studentGender = document.getElementById("studentGender");
    const studentDepId = document.getElementById("studentDepId");
    const studentPhone = document.getElementById("studentPhone");
    const studentParentPhone = document.getElementById("studentParentPhone");
    const studentAddress = document.getElementById("studentAddress");
    const studentImageInput = document.getElementById("studentImageInput");
    const studentImagePreview = document.getElementById("studentImagePreview");
    const studentImageLabel = document.getElementById("studentImageLabel");

    const resetToAddMode = function () {
      if (studentForm) {
        studentForm.setAttribute("action", "/admin/students");
      }
      if (studentModalTitle) {
        studentModalTitle.textContent = "Add Student";
      }
      if (studentModalSubmit) {
        studentModalSubmit.textContent = "Save Student";
      }
      if (studentEmail) studentEmail.value = "";
      if (studentRecordId) studentRecordId.value = "";
      if (studentCurrentImage) studentCurrentImage.value = "";
      if (studentStudentId) studentStudentId.value = "";
      if (studentFullName) studentFullName.value = "";
      if (studentAge) studentAge.value = "";
      if (studentGender) studentGender.value = "";
      if (studentDepId) studentDepId.value = "";
      if (studentPhone) studentPhone.value = "";
      if (studentParentPhone) studentParentPhone.value = "";
      if (studentAddress) studentAddress.value = "";
      if (studentImageInput) studentImageInput.value = "";
      if (studentImagePreview) {
        studentImagePreview.innerHTML =
          '<span class="text-muted-soft small">No image selected</span>';
      }
      if (studentImageLabel) {
        studentImageLabel.textContent = "Drag & Drop image here";
      }
      if (studentImageInput) {
        studentImageInput.setAttribute("required", "required");
      }
    };

    const updatePreviewFromUrl = function (imageUrl) {
      if (!studentImagePreview) {
        return;
      }

      if (imageUrl) {
        studentImagePreview.innerHTML =
          '<img src="/images/students/' + imageUrl + '" alt="Current image">';
      } else {
        studentImagePreview.innerHTML =
          '<span class="text-muted-soft small">No image selected</span>';
      }
    };

    document.querySelectorAll(".btn-edit-student").forEach(function (button) {
      button.addEventListener("click", function () {
        if (studentForm) {
          studentForm.setAttribute("action", "/admin/students/update");
        }
        if (studentModalTitle) {
          studentModalTitle.textContent = "Update Student";
        }
        if (studentModalSubmit) {
          studentModalSubmit.textContent = "Update Student";
        }
        if (studentImageInput) {
          studentImageInput.removeAttribute("required");
        }

        const dataset = button.dataset;
        if (studentRecordId) studentRecordId.value = dataset.recordId || "";
        if (studentCurrentImage)
          studentCurrentImage.value = dataset.image || "";
        if (studentStudentId) studentStudentId.value = dataset.studentId || "";
        if (studentEmail) studentEmail.value = dataset.email || "";
        if (studentFullName) studentFullName.value = dataset.fullName || "";
        if (studentAge) studentAge.value = dataset.age || "";
        if (studentGender) studentGender.value = dataset.gender || "";
        if (studentDepId) studentDepId.value = dataset.depId || "";
        if (studentPhone) studentPhone.value = dataset.phone || "";
        if (studentParentPhone)
          studentParentPhone.value = dataset.parentPhone || "";
        if (studentAddress) studentAddress.value = dataset.address || "";

        updatePreviewFromUrl(dataset.image || "");
      });
    });

    studentModal.addEventListener("hidden.bs.modal", resetToAddMode);
  }

  const departmentModal = document.getElementById("departmentModal");
  if (departmentModal) {
    const departmentForm = document.getElementById("departmentForm");
    const departmentModalTitle = document.getElementById(
      "departmentModalTitle",
    );
    const departmentModalSubmit = document.getElementById(
      "departmentModalSubmit",
    );
    const departmentRecordId = document.getElementById("departmentRecordId");
    const departmentNameInput = document.getElementById("departmentNameInput");
    const departmentCodeInput = document.getElementById("departmentCodeInput");

    const resetDepartmentForm = function () {
      if (departmentForm) {
        departmentForm.setAttribute("action", "/admin/departments");
      }
      if (departmentModalTitle) {
        departmentModalTitle.textContent = "Add Department";
      }
      if (departmentModalSubmit) {
        departmentModalSubmit.textContent = "Save Department";
      }
      if (departmentRecordId) departmentRecordId.value = "";
      if (departmentNameInput) departmentNameInput.value = "";
      if (departmentCodeInput) departmentCodeInput.value = "";
    };

    document
      .querySelectorAll(".btn-edit-department")
      .forEach(function (button) {
        button.addEventListener("click", function () {
          if (departmentForm) {
            departmentForm.setAttribute("action", "/admin/departments/update");
          }
          if (departmentModalTitle) {
            departmentModalTitle.textContent = "Update Department";
          }
          if (departmentModalSubmit) {
            departmentModalSubmit.textContent = "Update Department";
          }

          const dataset = button.dataset;
          if (departmentRecordId)
            departmentRecordId.value = dataset.depId || "";
          if (departmentNameInput)
            departmentNameInput.value = dataset.depName || "";
          if (departmentCodeInput)
            departmentCodeInput.value = dataset.depCode || "";
        });
      });

    departmentModal.addEventListener("hidden.bs.modal", resetDepartmentForm);
  }

  const courseModal = document.getElementById("courseModal");
  if (courseModal) {
    const courseForm = document.getElementById("courseForm");
    const courseModalTitle = document.getElementById("courseModalTitle");
    const courseModalSubmit = document.getElementById("courseModalSubmit");
    const courseRecordId = document.getElementById("courseRecordId");
    const courseNameInput = document.getElementById("courseNameInput");
    const courseDepartmentInput = document.getElementById(
      "courseDepartmentInput",
    );

    const resetCourseForm = function () {
      if (courseForm) {
        courseForm.setAttribute("action", "/admin/courses");
      }
      if (courseModalTitle) {
        courseModalTitle.textContent = "Add Course";
      }
      if (courseModalSubmit) {
        courseModalSubmit.textContent = "Save Course";
      }
      if (courseRecordId) courseRecordId.value = "";
      if (courseNameInput) courseNameInput.value = "";
      if (courseDepartmentInput) courseDepartmentInput.value = "";
    };

    document.querySelectorAll(".btn-edit-course").forEach(function (button) {
      button.addEventListener("click", function () {
        if (courseForm) {
          courseForm.setAttribute("action", "/admin/courses/update");
        }
        if (courseModalTitle) {
          courseModalTitle.textContent = "Update Course";
        }
        if (courseModalSubmit) {
          courseModalSubmit.textContent = "Update Course";
        }

        const dataset = button.dataset;
        if (courseRecordId) courseRecordId.value = dataset.courseId || "";
        if (courseNameInput) courseNameInput.value = dataset.courseName || "";
        if (courseDepartmentInput)
          courseDepartmentInput.value = dataset.departmentId || "";
      });
    });

    courseModal.addEventListener("hidden.bs.modal", resetCourseForm);
  }

  const courseScheduleModal = document.getElementById("courseScheduleModal");
  if (courseScheduleModal) {
    const courseScheduleForm = document.getElementById("courseScheduleForm");
    const courseScheduleModalTitle = document.getElementById(
      "courseScheduleModalTitle",
    );
    const courseScheduleModalSubmit = document.getElementById(
      "courseScheduleModalSubmit",
    );
    const courseScheduleRecordId = document.getElementById(
      "courseScheduleRecordId",
    );
    const courseScheduleCourseId = document.getElementById(
      "courseScheduleCourseId",
    );
    const courseScheduleDay = document.getElementById("courseScheduleDay");
    const courseScheduleStartTime = document.getElementById(
      "courseScheduleStartTime",
    );
    const courseScheduleEndTime = document.getElementById(
      "courseScheduleEndTime",
    );
    const courseScheduleRoom = document.getElementById("courseScheduleRoom");

    const resetCourseScheduleForm = function () {
      if (courseScheduleForm) {
        courseScheduleForm.setAttribute("action", "/admin/course-schedules");
      }
      if (courseScheduleModalTitle) {
        courseScheduleModalTitle.textContent = "Add Schedule";
      }
      if (courseScheduleModalSubmit) {
        courseScheduleModalSubmit.textContent = "Save Schedule";
      }
      if (courseScheduleRecordId) courseScheduleRecordId.value = "";
      if (courseScheduleCourseId) courseScheduleCourseId.value = "";
      if (courseScheduleDay) courseScheduleDay.value = "";
      if (courseScheduleStartTime) courseScheduleStartTime.value = "";
      if (courseScheduleEndTime) courseScheduleEndTime.value = "";
      if (courseScheduleRoom) courseScheduleRoom.value = "";
    };

    document
      .querySelectorAll(".btn-edit-course-schedule")
      .forEach(function (button) {
        button.addEventListener("click", function () {
          if (courseScheduleForm) {
            courseScheduleForm.setAttribute(
              "action",
              "/admin/course-schedules/update",
            );
          }
          if (courseScheduleModalTitle) {
            courseScheduleModalTitle.textContent = "Update Schedule";
          }
          if (courseScheduleModalSubmit) {
            courseScheduleModalSubmit.textContent = "Update Schedule";
          }

          const dataset = button.dataset;
          if (courseScheduleRecordId)
            courseScheduleRecordId.value = dataset.scheduleId || "";
          if (courseScheduleCourseId)
            courseScheduleCourseId.value = dataset.courseId || "";
          if (courseScheduleDay) courseScheduleDay.value = dataset.day || "";
          if (courseScheduleStartTime)
            courseScheduleStartTime.value = dataset.startTime || "";
          if (courseScheduleEndTime)
            courseScheduleEndTime.value = dataset.endTime || "";
          if (courseScheduleRoom) courseScheduleRoom.value = dataset.room || "";
        });
      });

    courseScheduleModal.addEventListener(
      "hidden.bs.modal",
      resetCourseScheduleForm,
    );
  }

  // Lightweight chart mock bars for dashboard placeholders
  document.querySelectorAll(".chart-placeholder").forEach(function (chart) {
    if (chart.querySelector(".chart-bar")) {
      return;
    }

    const values = [38, 65, 52, 80, 44, 72];
    values.forEach(function (value, index) {
      const bar = document.createElement("span");
      bar.className = "chart-bar";
      bar.style.left = 1.2 + index * 2.2 + "rem";
      bar.style.height = value + "%";
      chart.appendChild(bar);
    });
  });

  window.SCMS = {
    toast: createToast,
  };
})();
