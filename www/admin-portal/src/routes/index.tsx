import { Button, DatePickerDemo, Dialog, DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
    Drawer,
    DrawerClose,
    DrawerContent,
    DrawerDescription,
    DrawerFooter,
    DrawerHeader,
    DrawerTitle,
    DrawerTrigger, 
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
    ProfileForm,
    Accordion, AccordionContent, AccordionItem,
    AccordionTrigger, AlertDialog, AlertDialogAction,
    AlertDialogCancel, AlertDialogContent, AlertDialogDescription,
    AlertDialogFooter, AlertDialogHeader, AlertDialogTitle,
    AlertDialogTrigger, AspectRatio, Avatar, AvatarFallback, AvatarImage, Badge
  } from '@breeze/ui'

import { createFileRoute } from '@tanstack/react-router'


  

export const Route = createFileRoute('/')({
  component: () =><div className='flex flex-col gap-5 justify-center items-center min-h-screen'>
    <Dialog>
        <DialogTrigger className='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded'>Open Dialog</DialogTrigger>
            <DialogContent>
                <DialogHeader>
                <DialogTitle>Are you absolutely sure?</DialogTitle>
                <DialogDescription>
                    This action cannot be undone. This will permanently delete your account
                    and remove your data from our servers.
                </DialogDescription>
                </DialogHeader>
        </DialogContent>
    </Dialog>

    <Drawer>
        <DrawerTrigger className='bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded'>Open Drawer</DrawerTrigger>
        <DrawerContent>
            <DrawerHeader>
            <DrawerTitle>Are you absolutely sure?</DrawerTitle>
            <DrawerDescription>This action cannot be undone.</DrawerDescription>
            </DrawerHeader>
            <DrawerFooter>
            <Button>Submit</Button>
            <DrawerClose>
                <Button variant="outline">Cancel</Button>
            </DrawerClose>
            </DrawerFooter>
        </DrawerContent>
    </Drawer>

    <DropdownMenu>
        <DropdownMenuTrigger className='bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded'>Open Dropdown</DropdownMenuTrigger>
        <DropdownMenuContent>
            <DropdownMenuLabel>My Account</DropdownMenuLabel>
            <DropdownMenuSeparator />
            <DropdownMenuItem>Profile</DropdownMenuItem>
            <DropdownMenuItem>Billing</DropdownMenuItem>
            <DropdownMenuItem>Team</DropdownMenuItem>
            <DropdownMenuItem>Subscription</DropdownMenuItem>
        </DropdownMenuContent>

    </DropdownMenu>

    <DatePickerDemo />

    <ProfileForm />

    <div className='mx-60 my-16 p-7 border border-black rounded-xl'>
        <h1 className='my-5 font-bold text-xl'>This is Alert</h1>
        <Accordion type="single" collapsible>
            <AccordionItem value="item-1">
                <AccordionTrigger>Is it accessible?</AccordionTrigger>
                <AccordionContent>
                    Yes. It adheres to the WAI-ARIA design pattern.
                </AccordionContent>
            </AccordionItem>
        </Accordion>
        <br/>
        <h1 className='my-5 font-bold text-xl'>This is Alert-Dialog</h1>
            <AlertDialog>
            <AlertDialogTrigger className='border border-black rounded-xl px-8 py-2'>Open</AlertDialogTrigger>
            <AlertDialogContent>
                <AlertDialogHeader>
                <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
                <AlertDialogDescription>
                    This action cannot be undone. This will permanently delete your account
                    and remove your data from our servers.
                </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                <AlertDialogCancel>Cancel</AlertDialogCancel>
                <AlertDialogAction>Continue</AlertDialogAction>
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>
        <h1 className='my-5 font-bold text-xl'>This is Aspect-Ratio</h1>
        <div className="w-[450px]">
        <AspectRatio ratio={16 / 9}>
                <img src="https://i.pinimg.com/564x/a0/56/9e/a0569ebdf9d66c593b558742cd46eac9.jpg" alt="Beautiful Stone" className="rounded-md object-cover w-full h-full" />
        </AspectRatio>
        <h1 className='my-5 font-bold text-xl'>This is Avator</h1>
        <Avatar>
            <AvatarImage src="https://github.com/shadcn.png" />
            <AvatarFallback>CN</AvatarFallback>
            </Avatar>
            <h1 className='my-5 font-bold text-xl'>This is Badge</h1>
            <Badge variant="outline" className='border border-black rounded-xl px-8 py-2'>Badge</Badge>

</div>

  </div>

  </div> 
})