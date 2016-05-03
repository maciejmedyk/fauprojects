(defun filter-out-the (list)
        (cond
                ; End of the list
                ((null list) nil)
                ; Navigating through the list and skipping 'the'
                ((equal `the (car list))(filter-out-the(cdr list)))
                ; Constructing new list
                ((cons (car list)(filter-out-the (cdr list))))
        )
)