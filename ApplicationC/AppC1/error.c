
#include"error.h"

void errorMessage(t_program* program, char* message,char* title,GtkMessageType messageType, GtkButtonsType buttons)
{

    GtkWidget *dialog=NULL;
    dialog = gtk_message_dialog_new(GTK_WINDOW(program->pWindow),
                                    GTK_DIALOG_DESTROY_WITH_PARENT,
                                    messageType,
                                    buttons,
                                    message);
    gtk_window_set_title(GTK_WINDOW(dialog), title);
    gtk_dialog_run(GTK_DIALOG(dialog));
    gtk_widget_destroy(dialog);

}


